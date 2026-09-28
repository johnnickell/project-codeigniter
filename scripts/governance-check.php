<?php

declare(strict_types=1);

$required = [
    'AGENTS.md',
    'ARCHITECTURE.md',
    'CONTRIBUTING.md',
    'SECURITY.md',
    'planning/CONVENTIONS.md',
    'planning/README.md',
    'planning/tasks/BOARD.md',
    'planning/tasks/00001-TASK.md',
];

foreach ($required as $path) {
    if (! is_file($path)) {
        throw new RuntimeException("Required governance file is missing: {$path}");
    }
}

fwrite(STDOUT, "CodeIgniter governance contract passed.\n");
