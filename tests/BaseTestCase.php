<?php declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase;
use Tests\Utils\Http\Controllers\UserController;

class BaseTestCase extends TestCase
{
 protected function defineRoutes($router): void
 {
     $router->resource('users', UserController::class);
 }
}
