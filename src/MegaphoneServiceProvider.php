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
    public function register()
    {
        $this->registerConfigs();
    }

    public function boot()
    {
        $this->bootBlade();
        $this->bootConsole();
        $this->bootLivewireComponents();
        $this->bootPublishes();
        $this->bootViews();
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/megaphone.php',
            'megaphone'
        );
    }

    protected function bootBlade()
    {
        Blade::componentNamespace('MBarlow\\Megaphone\\Components', 'megaphone');

        Blade::directive(
            'megaphonePoll',
            function () {
                return '<?php
                if (config("megaphone.poll.enabled", false)) {
                    $poll = "wire:poll";
                    $poll .= (! empty($time = config("megaphone.poll.options.time"))) ? ".$time" : "";
                    $poll .= (config("megaphone.poll.options.keepAlive", false)) ? ".keepAlive" : "";
                    $poll .= (config("megaphone.poll.options.viewportVisible", false)) ? ".visible" : "";
                    echo $poll;
                }?>';
            }
        );
    }

    protected function bootConsole()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearOldNotifications::class,
            ]);
        }
    }

    protected function bootLivewireComponents()
    {
        Livewire::component('megaphone', Megaphone::class);
        Livewire::component('megaphone-admin', MegaphoneAdmin::class);
    }

    protected function bootPublishes()
    {
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

    protected function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'megaphone');
    }
}
