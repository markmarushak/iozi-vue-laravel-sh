<?php

return [
    'role_structure' => [
        
        'admin' => [
            'product.show',
            'product.delete',
        ],

        'user' => [
            'login',
            'register',

            'product.show',
            'product.create',
            'product.delete',
            'product.update',
        ]
    ],
    'permission_structure' => [
        
    ]
];
