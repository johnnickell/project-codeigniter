<?php

declare(strict_types=1);

$manifestJson = file_get_contents('composer.json');
$lockJson = file_get_contents('composer.lock');
if ($manifestJson === false || $lockJson === false) {
    throw new RuntimeException('Cannot read Composer manifest/lock.');
}
$manifest = json_decode($manifestJson, true, flags: JSON_THROW_ON_ERROR);
$lock = json_decode($lockJson, true, flags: JSON_THROW_ON_ERROR);

if (
    ($manifest['require']['php'] ?? null) !== '^8.5.12'
    || ($lock['platform']['php'] ?? null) !== '^8.5.12'
) {
    throw new RuntimeException('The declared and locked PHP support floor must be ^8.5.12.');
}

if (
    ($manifest['config']['platform']['php'] ?? null) !== '8.5.12'
    || ($lock['platform-overrides']['php'] ?? null) !== '8.5.12'
) {
    throw new RuntimeException('The declared and locked Composer platform PHP policy must be 8.5.12.');
}

if (PHP_VERSION_ID < 80512 || PHP_VERSION_ID >= 90000) {
    throw new RuntimeException('The actual PHP runtime must satisfy ^8.5.12.');
}

$requirements = [];
foreach ($lock['packages'] as $package) {
    if (in_array($package['name'], ['johnnickell/fight-common', 'johnnickell/fight-access-control'], true)) {
        $requirements[$package['name']] = $package['require']['php'] ?? null;
    }
}

if (
    $requirements !== [
    'johnnickell/fight-access-control' => '>=8.5',
    'johnnickell/fight-common'         => '>=8.5'
    ]
) {
    throw new RuntimeException('The locked Fight packages must both require PHP >=8.5.');
}

foreach (['8.4', '8.5.11'] as $unsupportedVersion) {
    $process = proc_open(
        ['composer', 'prohibits', 'php', $unsupportedVersion, '--locked', '--no-interaction'],
        [
            0 => ['file', '/dev/null', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ],
        $pipes
    );

    if (! is_resource($process)) {
        throw new RuntimeException('Could not start Composer prohibits.');
    }

    $output = stream_get_contents($pipes[1]).stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    if (proc_close($process) !== 1 || ! str_contains($output, 'requires php (^8.5.12)')) {
        throw new RuntimeException(
            "Composer prohibits must reject PHP {$unsupportedVersion} through the declared ^8.5.12 floor."
        );
    }
}

fwrite(STDOUT, "Composer runtime policy passed.\n");
