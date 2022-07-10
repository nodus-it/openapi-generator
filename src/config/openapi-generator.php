<?php

return [
    'routes' => [
        'excluded' => [
            '_debugbar',
            '_ignition',
            'horizon',
            'telescope',
        ],
        'prefix'   => 'api/v1/',
        'methods'  => ['GET', 'POST', 'PUT', 'DELETE'],
    ],

    'fields' => [
        'info'    => [
            'description'    => 'Your API description',
            'termsOfService' => '',
            'license'        => [
                'name' => '',
                'url'  => '',
            ]
        ],
        'servers' => [
            [
                'url'         => '',
                'description' => '',
            ],
        ]
    ]
];
