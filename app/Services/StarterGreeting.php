<?php

declare(strict_types=1);

namespace App\Services;

final class StarterGreeting
{
    public function title(): string
    {
        return 'Fight CodeIgniter Starter';
    }

    public function message(): string
    {
        return 'Hello, world.';
    }
}
