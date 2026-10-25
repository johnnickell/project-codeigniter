<?php

declare(strict_types=1);

// TASK-00014 deliberately pins the qualified release; do not hide other warnings.
$expectedWarning = '- require.johnnickell/fight-common : exact version constraints (1.4.0) should be avoided if the package follows semantic versioning';

$process = proc_open(
    ['composer', 'validate'],
    [
        0 => ['file', '/dev/null', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ],
    $pipes,
);

if (! is_resource($process)) {
    throw new RuntimeException('Could not start Composer validation.');
}

$output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);

$status = proc_close($process);
fwrite(STDOUT, $output);

if ($status !== 0) {
    throw new RuntimeException('Composer validation failed.');
}

$warnings = [];
$inGeneralWarnings = false;

foreach (preg_split('/\R/', $output) as $line) {
    if ($line === '# General warnings') {
        $inGeneralWarnings = true;

        continue;
    }

    if ($inGeneralWarnings && str_starts_with($line, '- ')) {
        $warnings[] = $line;
    }
}

if ($warnings !== [$expectedWarning]) {
    throw new RuntimeException(sprintf(
        'Composer validation warnings must contain only the accepted Fight Common exact stable version warning; received: %s',
        json_encode($warnings, JSON_THROW_ON_ERROR),
    ));
}

fwrite(STDOUT, "Composer validation warning allowlist passed.\n");
