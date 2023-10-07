<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Config\Repository;
use Orchestra\Testbench\TestCase;
use Tests\Utils\Http\Controllers\UserController;
use Tests\Utils\Http\Controllers\UserPostCommentController;
use function Orchestra\Testbench\workbench_path;

class BaseTestCase extends TestCase
{
    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config) {
            $config->set('database.default', 'testing');
            $config->set('database.connections.testing', [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]);
        });
    }

    protected function defineRoutes($router): void
    {
        $router->resource('users', UserController::class);
        $router->resource('users.posts.comments', UserPostCommentController::class);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Utils/Database/Migrations');
    }
}
