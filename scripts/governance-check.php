<?php

declare(strict_types=1);

$required = [
    'AGENTS.md',
    'ARCHITECTURE.md',
    'CONTRIBUTING.md',
    'SECURITY.md',
    'planning/CONVENTIONS.md',
    'planning/README.md',
    'planning/tickets/BOARD.md',
    'planning/tickets/00001-TICKET.md',
];

foreach ($required as $path) {
    if (! is_file($path)) {
        throw new RuntimeException("Required governance file is missing: {$path}");
    }
}

fwrite(STDOUT, "CodeIgniter governance contract passed.\n");
