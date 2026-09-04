<?php

declare(strict_types=1);

const FIGHT_COMMON_REFERENCE = '4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16';
const FIGHT_COMMON_CONSTRAINT = 'dev-develop#4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16 as 1.2.0-dev';

const APPROVED_RUNTIME_REQUIREMENTS = [
    'codeigniter4/framework',
    'codeigniter4/queue',
    'doctrine/dbal',
    'dragonmantank/cron-expression',
    'guzzlehttp/guzzle',
    'johnnickell/fight-access-control',
    'johnnickell/fight-common',
    'lcobucci/jwt',
    'league/flysystem',
    'php',
    'phpseclib/phpseclib',
    'symfony/filesystem',
    'symfony/mailer',
    'symfony/mercure',
    'symfony/process',
    'twig/twig',
    'twilio/sdk',
];

/** @var array<string, true> */
const APPROVED_SYMFONY_PACKAGES = [
    'symfony/deprecation-contracts' => true,
    'symfony/event-dispatcher' => true,
    'symfony/event-dispatcher-contracts' => true,
    'symfony/filesystem' => true,
    'symfony/http-client' => true,
    'symfony/http-client-contracts' => true,
    'symfony/http-foundation' => true,
    'symfony/mailer' => true,
    'symfony/mercure' => true,
    'symfony/mime' => true,
    'symfony/polyfill-ctype' => true,
    'symfony/polyfill-intl-idn' => true,
    'symfony/polyfill-intl-normalizer' => true,
    'symfony/polyfill-mbstring' => true,
    'symfony/polyfill-php72' => true,
    'symfony/polyfill-php80' => true,
    'symfony/polyfill-php83' => true,
    'symfony/process' => true,
    'symfony/service-contracts' => true,
    'symfony/web-link' => true,
];

const FORBIDDEN_PACKAGE_PREFIXES = [
    'laravel/',
    'illuminate/',
    'yiisoft/',
    'slim/',
    'aws/',
    'google/',
    'microsoft/',
    'pusher/',
    'predis/',
    'php-amqplib/',
    'enqueue/',
    'league/oauth2-',
    'sendgrid/',
    'mailgun/',
    'vonage/',
    'telnyx/',
    'plivo/',
];

$mode = $argv[1] ?? 'verify';
if (! in_array($mode, ['verify', 'refresh'], true)) {
    throw new InvalidArgumentException('Usage: php scripts/verify-framework-support-lanes.php [verify|refresh]');
}

$root = dirname(__DIR__);
$evidenceDirectory = $root . '/evidence/framework-support';
$lowestLock = $evidenceDirectory . '/composer-lowest.lock';
$lowestDigest = $evidenceDirectory . '/composer-lowest.lock.sha256';

if ($mode === 'refresh') {
    $latest = createLane($root, 'latest');
    try {
        run($latest, ['composer', 'update', '--with-all-dependencies', '--no-interaction', '--prefer-dist', '--no-progress']);
        verifyLane($latest, 'latest');
        copyFile($latest . '/composer.lock', $root . '/composer.lock');

        $lowest = createLane($root, 'lowest');
        try {
            run($lowest, ['composer', 'update', '--with-all-dependencies', '--prefer-lowest', '--no-interaction', '--prefer-dist', '--no-progress']);
            verifyLane($lowest, 'lowest');
            if (! is_dir($evidenceDirectory) && ! mkdir($evidenceDirectory, 0777, true) && ! is_dir($evidenceDirectory)) {
                throw new RuntimeException(sprintf('Could not create %s.', $evidenceDirectory));
            }
            copyFile($lowest . '/composer.lock', $lowestLock);
            file_put_contents($lowestDigest, hash_file('sha256', $lowestLock) . "  composer-lowest.lock\n");
        } finally {
            removeDirectory($lowest);
        }
    } finally {
        removeDirectory($latest);
    }
} else {
    requireFile($lowestLock);
    requireFile($lowestDigest);
    verifyDigest($lowestLock, $lowestDigest);

    $latest = createLane($root, 'latest');
    try {
        verifyLane(
            $latest,
            'latest',
            ['composer', 'update', '--with-all-dependencies', '--no-interaction', '--prefer-dist', '--no-progress'],
            hash_file('sha256', $root . '/composer.lock'),
        );
    } finally {
        removeDirectory($latest);
    }

    $lowest = createLane($root, 'lowest');
    try {
        verifyLane(
            $lowest,
            'lowest',
            ['composer', 'update', '--with-all-dependencies', '--prefer-lowest', '--no-interaction', '--prefer-dist', '--no-progress'],
            hash_file('sha256', $lowestLock),
        );
    } finally {
        removeDirectory($lowest);
    }
}

fwrite(STDOUT, "Framework-support dependency lanes passed.\n");

function createLane(string $root, string $name): string
{
    $lane = sys_get_temp_dir() . '/project-codeigniter-framework-support-' . $name . '-' . bin2hex(random_bytes(6));
    if (! mkdir($lane, 0700) && ! is_dir($lane)) {
        throw new RuntimeException(sprintf('Could not create lane %s.', $lane));
    }

    $command = sprintf(
        'tar --exclude=.git --exclude=vendor --exclude=.runs --exclude=writable --exclude=evidence/framework-support -C %s -cf - . | tar -C %s -xf -',
        escapeshellarg($root),
        escapeshellarg($lane),
    );
    passthru($command, $status);
    if ($status !== 0) {
        removeDirectory($lane);
        throw new RuntimeException(sprintf('Could not prepare %s lane.', $name));
    }

    foreach (['cache', 'debugbar', 'logs', 'session', 'uploads'] as $directory) {
        $path = $lane . '/writable/' . $directory;
        if (! mkdir($path, 0777, true) && ! is_dir($path)) {
            removeDirectory($lane);
            throw new RuntimeException(sprintf('Could not prepare writable path %s.', $path));
        }
    }

    return $lane;
}

/** @param list<string> $resolutionCommand */
function verifyLane(string $lane, string $name, array $resolutionCommand = [], ?string $expectedLockDigest = null): void
{
    verifyManifest($lane . '/composer.json');
    if ($resolutionCommand !== []) {
        run($lane, $resolutionCommand);
    }
    verifyLock($lane . '/composer.lock', $name);
    if ($expectedLockDigest !== null && ! hash_equals($expectedLockDigest, hash_file('sha256', $lane . '/composer.lock'))) {
        throw new RuntimeException(sprintf(
            '%s lane resolution drifted from committed lock evidence; run ./bin/refresh-framework-support-lanes only when deliberately regenerating evidence.',
            $name,
        ));
    }
    $beforeInstall = hash_file('sha256', $lane . '/composer.lock');
    run($lane, ['composer', 'install', '--no-interaction', '--prefer-dist', '--no-progress']);
    if ($beforeInstall !== hash_file('sha256', $lane . '/composer.lock')) {
        throw new RuntimeException(sprintf('%s lane Composer install mutated composer.lock.', $name));
    }
    run($lane, ['php', 'vendor/bin/phpunit', '--no-coverage', '--filter', 'FrameworkSupportJourneyTest']);
}

function verifyManifest(string $manifestPath): void
{
    $manifest = json_decode(file_get_contents($manifestPath), true, flags: JSON_THROW_ON_ERROR);
    $requirements = array_keys($manifest['require'] ?? []);
    sort($requirements);
    if ($requirements !== APPROVED_RUNTIME_REQUIREMENTS) {
        throw new RuntimeException('The framework-support profile may declare only the selected CodeIgniter and fallback runtime providers.');
    }
    if (($manifest['require']['johnnickell/fight-common'] ?? null) !== FIGHT_COMMON_CONSTRAINT) {
        throw new RuntimeException('Every dependency lane must retain the required immutable Fight Common candidate constraint.');
    }
}

function verifyLock(string $lockPath, string $name): void
{
    $lock = json_decode(file_get_contents($lockPath), true, flags: JSON_THROW_ON_ERROR);
    $packages = array_merge($lock['packages'] ?? [], $lock['packages-dev'] ?? []);
    $common = null;

    foreach ($packages as $package) {
        $packageName = $package['name'] ?? '';
        if ($packageName === 'johnnickell/fight-common') {
            $common = $package;
        }
        if (str_starts_with($packageName, 'symfony/') && ! isset(APPROVED_SYMFONY_PACKAGES[$packageName])) {
            throw new RuntimeException(sprintf('%s lane contains unsupported Symfony framework package %s.', $name, $packageName));
        }
        foreach (FORBIDDEN_PACKAGE_PREFIXES as $prefix) {
            if (str_starts_with($packageName, $prefix)) {
                throw new RuntimeException(sprintf('%s lane contains forbidden provider/framework package %s.', $name, $packageName));
            }
        }
    }

    if (($common['version'] ?? null) !== 'dev-develop' || ($common['source']['reference'] ?? null) !== FIGHT_COMMON_REFERENCE) {
        throw new RuntimeException(sprintf('%s lane does not lock the required Fight Common candidate identity.', $name));
    }
}

/** @param list<string> $command */
function run(string $directory, array $command): void
{
    $process = proc_open(
        $command,
        [
            0 => ['file', '/dev/null', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ],
        $pipes,
        $directory,
        ['PROJECT_CODEIGNITER_IN_BUILD' => '1'] + getenv(),
    );
    if (! is_resource($process)) {
        throw new RuntimeException('Could not start dependency-lane command.');
    }

    $output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $status = proc_close($process);
    fwrite(STDOUT, $output);
    if ($status !== 0) {
        throw new RuntimeException(sprintf('Dependency-lane command failed: %s', implode(' ', $command)));
    }
}

function verifyDigest(string $lockPath, string $digestPath): void
{
    $expected = hash_file('sha256', $lockPath) . '  composer-lowest.lock';
    $actual = trim((string) file_get_contents($digestPath));
    if ($actual !== $expected) {
        throw new RuntimeException('composer-lowest.lock SHA-256 evidence does not match the committed lock.');
    }
}

function requireFile(string $path): void
{
    if (! is_file($path)) {
        throw new RuntimeException(sprintf('Required framework-support lane evidence is missing: %s', $path));
    }
}

function copyFile(string $source, string $target): void
{
    if (! copy($source, $target)) {
        throw new RuntimeException(sprintf('Could not copy %s to %s.', $source, $target));
    }
}

function removeDirectory(string $directory): void
{
    if (! is_dir($directory)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );
    foreach ($iterator as $entry) {
        $entry->isDir() ? rmdir($entry->getPathname()) : unlink($entry->getPathname());
    }
    rmdir($directory);
}
