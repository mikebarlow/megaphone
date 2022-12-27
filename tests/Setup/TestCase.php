<?php

namespace MBarlow\Megaphone\Tests\Setup;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Livewire\LivewireServiceProvider;
use MBarlow\Megaphone\MegaphoneServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use function Pest\Faker\faker;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        View::addNamespace('tests', __DIR__ . '/views');
    }

    protected function createTestUser(): User
    {
        $faker = faker();
        $user = new User();
        $user->name = $faker->name;
        $user->email = $faker->email;
        $user->password = 'password';
        $user->save();

        return $user;
    }

    protected function createTestNotification($user, $notifClass)
    {
        $faker = faker();

        $notification = new $notifClass(
            $faker->sentence,
            $faker->sentence(15),
            $faker->url
        );
        $user->notify($notification);

        return $notification;
    }

    protected function bellSvgIcon(): string
    {
        return '<svg class="h-full w-full fill-black dark:fill-white" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
    </svg>';
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            MegaphoneServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:ZbyuV9rX+l9oG8GE+9RLHyle+IpYV2KQWVkvjiSsKmg=');

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('megaphone.model', User::class);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
