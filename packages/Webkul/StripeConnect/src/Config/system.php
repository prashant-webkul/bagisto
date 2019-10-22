<?php

return [
    [
        'key' => 'stripe',
        'name' => 'RazzoPay',
        'sort' => 5
    ], [
        'key' => 'stripe.connect',
        'name' => 'Connect Account',
        'sort' => 1,
    ], [
        'key' => 'stripe.connect.details',
        'name' => 'Account Details',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'stripefees',
                'title' => 'RazzoPay fee to be paid by customer or seller',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Seller',
                        'value' => 'seller'
                    ], [
                        'title' => 'Customer',
                        'value' => 'customer'
                    ]
                ],
                'validation' => 'required'
            ], [
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Active',
                        'value' => true
                    ], [
                        'title' => 'Inactive',
                        'value' => false
                    ]
                ],
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ], [
                'name' => 'statementdescriptor',
                'title' => 'Statement Descriptor',
                'type' => 'text'
            ]
        ]
    ]
];