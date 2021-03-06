<?php

namespace Webkul\SAASCustomizer\Models\User;

use Webkul\User\Models\Role as BaseModel;

use Company;

class Role extends BaseModel
{
    protected $fillable = [
        'name', 'description', 'permission_type', 'permissions', 'company_id'
    ];
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        $company = Company::getCurrent();

        if (auth()->guard('super-admin')->check() || ! isset($company->id)) {
            return new \Illuminate\Database\Eloquent\Builder($query);
        } else {
            return new \Illuminate\Database\Eloquent\Builder($query->where('roles' . '.company_id', $company->id));
        }
    }
}