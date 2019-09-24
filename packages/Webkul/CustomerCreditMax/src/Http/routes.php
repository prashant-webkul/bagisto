<?php

Route::post('customer/creditMax/{id}', 'Webkul\CustomerCreditMax\Http\Controllers\CreditMaxController@syncCreditMax')->name('customer.creditmax.sync');