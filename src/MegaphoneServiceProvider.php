<?php

namespace MBarlow\Megaphone;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use MBarlow\Megaphone\Console\ClearOldNotifications;
use MBarlow\Megaphone\Livewire\Megaphone;
use MBarlow\Megaphone\Livewire\MegaphoneAdmin;

class MegaphoneServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearOldNotifications::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'megaphone');
        $this->mergeConfigFrom(
            __DIR__.'/../config/megaphone.php',
            'megaphone'
        );

        Blade::componentNamespace('MBarlow\\Megaphone\\Components', 'megaphone');

        Livewire::component(
            'megaphone',
            Megaphone::class
        );

        Livewire::component(
            'megaphone-admin',
            MegaphoneAdmin::class
        );

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/megaphone'),
            __DIR__.'/../config/megaphone.php' => config_path('megaphone.php'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/megaphone'),
        ], 'megaphone');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/megaphone'),
        ], 'megaphone-assets');

        $this->publishes([
            __DIR__.'/../config/megaphone.php' => config_path('megaphone.php'),
        ], 'megaphone-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/megaphone'),
        ], 'megaphone-views');
    }
}
