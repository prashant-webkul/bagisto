<?php

namespace Webkul\CustomerCreditMax\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class CustomerCreditMaxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'creditmax');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'customercreditmax');

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }
}