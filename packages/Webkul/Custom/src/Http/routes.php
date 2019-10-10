<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/contact-us/response/{data}', 'Webkul\Custom\Http\Controllers\CustomController@contactUsResponse')->name('custom.contact-us.response');

    Route::post('contact-us/submit', 'Webkul\Custom\Http\Controllers\CustomController@sendContactEmail')->name('contact-from.mail');
});