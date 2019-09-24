<?php

namespace Webkul\CustomerCreditMax\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\CustomerCreditMax\Models\CustomerCreditMax::class
    ];
}