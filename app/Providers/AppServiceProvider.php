<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Thedevsaddam\LumenRouteList\LumenRouteListServiceProvider;
use Wn\Generators\CommandsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(LumenRouteListServiceProvider::class);
            $this->app->register(CommandsServiceProvider::class);
        }
    }
}
