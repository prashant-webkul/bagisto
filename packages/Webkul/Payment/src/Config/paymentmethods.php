<?php
return [
    'cashondelivery' => [
        'code' => 'cashondelivery',
        'title' => 'Cash On Delivery',
        'description' => 'shop::app.checkout.onepage.cash-desc',
        'class' => 'Webkul\Payment\Payment\CashOnDelivery',
        'active' => false,
        'sort' => 1,
        'default' => 'yes'
    ],

    'moneytransfer' => [
        'code' => 'moneytransfer',
        'title' => 'Invoice',
        'description' => 'Invoice Payments',
        'class' => 'Webkul\Payment\Payment\MoneyTransfer',
        'active' => true,
        'sort' => 2,
        'default' => 'no'
    ],

    'paypal_standard' => [
        'code' => 'paypal_standard',
        'title' => 'Paypal Standard',
        'description' => 'shop::app.checkout.onepage.paypal-desc',
        'class' => 'Webkul\Paypal\Payment\Standard',
        'sandbox' => true,
        'active' => false,
        'business_account' => 'test@webkul.com',
        'sort' => 3,
        'default' => 'no'
    ]
];