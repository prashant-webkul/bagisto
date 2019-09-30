<?php

return [
    [
        'key' => 'customer.settings.credit_max',
        'name' => 'customercreditmax::app.admin.system.credit-max',
        'sort' => 4,
        'fields' => [
            [
                'name' => 'status',
                'title' => 'customercreditmax::app.admin.system.use-credit-max',
                'type' => 'boolean',
                'channel_based' => true
            ]
        ]
    ]
];