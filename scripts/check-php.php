<?php

declare(strict_types=1);

use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

require dirname(__DIR__).'/vendor/autoload.php';

$root = dirname(__DIR__);
$files = iterator_to_array(Finder::create()->files()->name('*.php')->in([
    $root.'/app', $root.'/tests', $root.'/scripts', $root.'/public'
])->sortByName());
$paths = array_map(static fn (SplFileInfo $file): string => $file->getPathname(), array_values($files));
$paths = [...$paths, $root.'/spark', $root.'/preload.php', $root.'/rector.php'];
$parser = (new ParserFactory())->createForNewestSupportedVersion();
$traverser = new NodeTraverser(new NameResolver());
$finder = new NodeFinder();
$types = 0;

foreach ($paths as $path) {
    $lint = new Process([PHP_BINARY, '-l', $path]);
    $lint->mustRun();
    $source = file_get_contents($path);
    if ($source === false) {
        throw new RuntimeException('Cannot read maintained PHP: '.$path);
    }
    $nodes = $traverser->traverse($parser->parse($source) ?? []);
    $declarations = $finder->findInstanceOf($nodes, Declare_::class);
    $strict = false;
    foreach ($declarations as $declaration) {
        foreach ($declaration->declares as $item) {
            if (
                $item->key->toString() === 'strict_types'
                && $item->value instanceof \PhpParser\Node\Scalar\Int_
                && $item->value->value === 1
            ) {
                $strict = true;
            }
        }
    }
    if (!$strict) {
        throw new RuntimeException('Missing strict types: '.$path);
    }
    $relative = substr($path, strlen($root) + 1);
    foreach ($finder->findInstanceOf($nodes, ClassLike::class) as $class) {
        if ($class->name === null) {
            continue;
        }
        $types++;
        $name = $class->namespacedName->toString();
        if ($relative === 'preload.php' && $name === 'preload') {
            continue; // Native opt-in global preloader, not application discovery.
        }
        $prefixes = [
            'app/Config/'      => 'Config\\',
            'app/'             => 'App\\',
            'tests/_support/'  => 'Tests\\Support\\',
            'tests/feature/'   => 'Tests\\Feature\\',
            'tests/database/'  => 'Tests\\Database\\',
            'tests/session/'   => 'Tests\\Session\\',
            'tests/unit/'      => 'Tests\\Unit\\',
            'scripts/Quality/' => 'Quality\\'
        ];
        $matched = false;
        foreach ($prefixes as $directory => $namespace) {
            if (!str_starts_with($relative, $directory)) {
                continue;
            }
            $expected = $namespace.str_replace('/', '\\', substr($relative, strlen($directory), -4));
            $fixture = in_array($relative, [
                'tests/feature/FightCommonIntegrationTest.php',
                'tests/feature/FightTransactionIntegrationTest.php'
            ], true) && str_starts_with($name, 'Tests\\Feature\\');
            $migration = $relative === 'tests/_support/Database/Migrations/2020-02-22-222222_example_migration.php'
                && $name === 'Tests\\Support\\Database\\Migrations\\ExampleMigration';
            if ($name !== $expected && !$fixture && !$migration) {
                throw new RuntimeException('Namespace/path mismatch: '.$relative.' declares '.$name);
            }
            $matched = true;
            break;
        }
        if (!$matched) {
            throw new RuntimeException('Unclassified named PHP type: '.$relative.' declares '.$name);
        }
    }
}
printf("PHP syntax/strict-types/namespaces passed: %d files, %d named types.\n", count($paths), $types);
