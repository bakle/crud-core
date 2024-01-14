<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Tests\Utils\Http\Controllers\UserController;
use Tests\Utils\Http\Controllers\UserPostCommentController;
use function Orchestra\Testbench\workbench_path;

class BaseTestCase extends TestCase
{
    use RefreshDatabase;

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

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Utils/Database/Migrations');
    }

    protected function defineViews(): void
    {
        $this->app['view']->addLocation(__DIR__.'/Utils/Resources/Views');
    }
}
