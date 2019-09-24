<?php

namespace Webkul\CustomerCreditMax\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;

/**
 * CustomerCreditMax Reposotory
 *
 */
class CustomerCreditMaxRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\CustomerCreditMax\Contracts\CustomerCreditMax';
    }
}