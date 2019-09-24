<?php

namespace Webkul\CustomerCreditMax\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('checkout.cart.add.before', 'Webkul\CustomerCreditMax\Listeners\Cart@cartItemAddBefore');

        Event::listen('bagisto.admin.customer.edit.after', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('creditmax::admin.customers.creditmax');
        });
    }
}