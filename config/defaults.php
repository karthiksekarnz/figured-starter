<?php

return [
    'token-expiry-seconds' => 604800,
    'roles' => [
        'admin' => 'Admin',
        'reader' => 'Reader'
    ],
    'permissions' => [
        'manage-posts',
        'view-posts'
    ],
    'role_has_permissions' => [
        'Admin' => [
            'manage-posts',
            'view-posts'
        ],
        'Reader' => [
            'view-posts'
        ]
    ]
];
