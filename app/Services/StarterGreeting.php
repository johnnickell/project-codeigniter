<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Class StarterGreeting
 */
final class StarterGreeting
{
    /**
     * Returns the starter page title
     */
    public function title(): string
    {
        return 'Fight CodeIgniter Starter';
    }

    /**
     * Returns the public hello-world greeting
     */
    public function message(): string
    {
        return 'Hello, world.';
    }
}
