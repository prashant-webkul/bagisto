<?php

return [
    [
        'key' => 'general.design.webfont',
        'name' => 'webfont::app.webfont',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'status',
                'title' => 'webfont::app.webfont-status',
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

                'channel_based' => false,
                'locale_based' => false
            ], [
                'name' => 'enable_backend',
                'title' => 'webfont::app.webfont-backend',
                'type' => 'select',
                'channel_based' => false,
                'locale_based' => false,
                'options' => [
                    [
                        'title' => 'Active',
                        'value' => true
                    ], [
                        'title' => 'Inactive',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'enable_frontend',
                'title' => 'webfont::app.webfont-frontend',
                'type' => 'select',
                'channel_based' => false,
                'locale_based' => false,
                'options' => [
                    [
                        'title' => 'Active',
                        'value' => true
                    ], [
                        'title' => 'Inactive',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'primary_color',
                'title' => 'webfont::app.webfont-primary',
                'type' => 'color',
                'channel_based' => false,
                'locale_based' => false
            ], [
                'name' => 'secondary_color',
                'title' => 'webfont::app.webfont-secondary',
                'type' => 'color',
                'channel_based' => false,
                'locale_based' => false
            ]
        ]
    ]
];