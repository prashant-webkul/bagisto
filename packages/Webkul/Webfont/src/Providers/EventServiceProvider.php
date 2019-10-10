<?php

namespace Webkul\Webfont\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use View;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            \Company::getCurrent();

            Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('webfont::webfont');
            });

            Event::listen('bagisto.shop.layout.head', function($viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('webfont::webfont');
            });
        } catch (\Exception $e) {

        }
    }
}