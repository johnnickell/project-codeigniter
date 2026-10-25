<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Controllers\Home;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

/**
 * Class HelloWorldTest
 */
final class HelloWorldTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function test_home_displays_the_fight_codeigniter_hello_world_message(): void
    {
        $result = $this->controller(Home::class)->execute('index');

        $result->assertOK();
        $result->assertSee('Fight CodeIgniter Starter');
        $result->assertSee('Hello, world.');
    }
}
