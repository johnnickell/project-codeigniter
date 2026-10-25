<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\StarterGreeting;

/**
 * Class Home
 */
final class Home extends BaseController
{
    /**
     * Renders the native starter page
     */
    public function index(): string
    {
        /** @var StarterGreeting $greeting */
        $greeting = service('starterGreeting');

        return view('home', [
            'message' => $greeting->message(),
            'title'   => $greeting->title()
        ]);
    }
}
