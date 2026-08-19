<?php

namespace App\Controllers;

final class Home extends BaseController
{
    public function index(): string
    {
        $greeting = service('starterGreeting');

        return view('home', [
            'message' => $greeting->message(),
            'title' => $greeting->title(),
        ]);
    }
}
