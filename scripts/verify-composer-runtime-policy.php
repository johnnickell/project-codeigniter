<?php

declare(strict_types=1);

$manifest = json_decode(file_get_contents('composer.json'), true, flags: JSON_THROW_ON_ERROR);
$lock = json_decode(file_get_contents('composer.lock'), true, flags: JSON_THROW_ON_ERROR);

if (($manifest['require']['php'] ?? null) !== '^8.5') {
    throw new RuntimeException('The declared PHP support floor must be ^8.5.');
}

if (($manifest['config']['platform']['php'] ?? null) !== '8.5.4') {
    throw new RuntimeException('The Composer platform PHP policy must be 8.5.4.');
}

$requirements = [];
foreach ($lock['packages'] as $package) {
    if (in_array($package['name'], ['johnnickell/fight-common', 'johnnickell/fight-access-control'], true)) {
        $requirements[$package['name']] = $package['require']['php'] ?? null;
    }
}

if ($requirements !== [
    'johnnickell/fight-access-control' => '>=8.5',
    'johnnickell/fight-common' => '>=8.5',
]) {
    throw new RuntimeException('The locked Fight packages must both require PHP >=8.5.');
}

$process = proc_open(
    ['composer', 'prohibits', 'php', '8.4', '--locked', '--no-interaction'],
    [
        0 => ['file', '/dev/null', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ],
    $pipes,
);

if (! is_resource($process)) {
    throw new RuntimeException('Could not start Composer prohibits.');
}

$output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);

if (proc_close($process) !== 1 || ! str_contains($output, 'requires php (^8.5)')) {
    throw new RuntimeException('Composer prohibits must reject PHP 8.4 through the declared ^8.5 floor.');
}

fwrite(STDOUT, "Composer runtime policy passed.\n");
