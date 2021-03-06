<?php

namespace Webkul\Custom\Observers;

use Webkul\Custom\Models\Slider;

use Company;

class SliderObserver
{
    public function creating(Slider $model)
    {
        if (! auth()->guard('super-admin')->check()) {
            $model->company_id = Company::getCurrent()->id;
        }
    }

    public function saving(Slider $model)
    {
        if (! auth()->guard('super-admin')->check()) {
            $model->company_id = Company::getCurrent()->id;
        }
    }
}