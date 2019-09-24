<?php

namespace Webkul\CustomerCreditMax\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\CustomerCreditMax\Contracts\CustomerCreditMax as CustomerCreditMaxContract;

class CustomerCreditMax extends Model implements CustomerCreditMaxContract
{
    protected $table = 'customer_credit_max';

    protected $fillable = ['customer_id', 'company_id', 'limit'];
}