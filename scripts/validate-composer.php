<?php

declare(strict_types=1);

// TASK-00014 deliberately pins the qualified release; do not hide other warnings.
// phpcs:ignore Generic.Files.LineLength -- Match Composer's exact accepted diagnostic.
$expectedWarning = '- require.johnnickell/fight-common : exact version constraints (1.4.0) should be avoided if the package follows semantic versioning';

$process = proc_open(
    ['composer', 'validate'],
    [
        0 => ['file', '/dev/null', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ],
    $pipes
);

if (! is_resource($process)) {
    throw new RuntimeException('Could not start Composer validation.');
}

$output = stream_get_contents($pipes[1]).stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);

$status = proc_close($process);
fwrite(STDOUT, $output);

if ($status !== 0) {
    throw new RuntimeException('Composer validation failed.');
}

$warnings = [];
$inGeneralWarnings = false;

foreach (explode("\n", str_replace("\r", '', $output)) as $line) {
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
        // phpcs:ignore Generic.Files.LineLength -- Preserve the full remediation diagnostic.
        'Composer validation warnings must contain only the accepted Fight Common exact stable version warning; received: %s',
        json_encode($warnings, JSON_THROW_ON_ERROR)
    ));
}

fwrite(STDOUT, "Composer validation warning allowlist passed.\n");
