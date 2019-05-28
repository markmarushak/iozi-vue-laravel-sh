<?php

return [
    'role_structure' => [

        'account' => [
            'product.show',
            'products.store',
            'products.destroy',
            'product.update',
            'products.image',
            'products.image.upload',

            'attribute.store',
            'attribute.destroy',
            'attribute.update',
            'payment.show',

            'get.user',

            'pyment.show'
        ],

        'admin' => [

            'product.show',
            'products.store',
            'products.destroy',
            'product.update',
            'products.image',
            'products.image.upload',

            'attribute.store',
            'attribute.destroy',
            'attribute.update',
            'payment.show',

            'get.user'
        ],

        'super-admin' => [
            'product.show',
            'products.store',
            'products.destroy',
            'product.update',
            'products.image',
            'products.image.upload',

            'attribute.store',
            'attribute.destroy',
            'attribute.update',
            'payment.show',

            'get.user'
        ]

    ],
    'permission_structure' => [],

    'access_levels' => [
        'super-admin' => 1,
        'admin' => 2,
        'account' => 3,
    ],
];
