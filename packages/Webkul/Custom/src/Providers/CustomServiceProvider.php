<?php

namespace Webkul\Custom\Providers;

use Webkul\Custom\Providers\EventServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class CustomServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'custom');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'custom');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->concord->registerModel(\Webkul\Core\Contracts\Slider::class, \Webkul\Custom\Models\Slider::class);

        \Webkul\SAASCustomizer\Models\Customer\Customer::observe(\Webkul\Custom\Observers\CustomerObserver::class);

        \Webkul\Custom\Models\Slider::observe(\Webkul\Custom\Observers\SliderObserver::class);

        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('vendor/webkul/custom/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/navmenu.blade.php' => resource_path('views/vendor/shop/layouts/header/nav-menu/navmenu.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop-header.blade.php' => resource_path('views/vendor/shop/layouts/header/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/nav-top.blade.php' => resource_path('views/vendor/admin/layouts/nav-top.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/nav-top.blade.php' => resource_path('views/vendor/admin/layouts/nav-top.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/saas-top.blade.php' => resource_path('views/vendor/saas/companies/layouts/nav-top.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/admin-anon.blade.php' => resource_path('views/vendor/admin/layouts/anonymous-master.blade.php'),
        ]);
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }
}