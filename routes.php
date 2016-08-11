<?php

return [
    [
        'get', '/',
        '\\Mwyatt\\Portfolio\\Controller', 'home',
        ['id' => 'home']
    ],
    [
        'get', '/admin/',
        '\\Mwyatt\\Portfolio\\Admin\\Controller', 'home',
        ['id' => 'admin.home']
    ],
    [
        'get', '/:slug/',
        '\\Mwyatt\\Portfolio\\Controller\\Post', 'single',
        ['id' => 'post.single']
    ],
    [
        'get', '/admin/logout/',
        '\\Mwyatt\\Portfolio\\Admin\\Controller', 'logout',
        ['id' => 'admin.logout']
    ],
    [
        'post', '/admin/',
        '\\Mwyatt\\Portfolio\\Admin\\Controller', 'login'
    ],
    [
        'get', '/admin/:slug/',
        '\\Mwyatt\\Portfolio\\Admin\\Controller\\Post', 'single',
        ['id' => 'admin.post.single']
    ],
    [
        'post', '/admin/:slug/',
        '\\Mwyatt\\Portfolio\\Admin\\Controller\\Post', 'persist'
    ],
    [
        'get', '/cv/:name/',
        '\\Mwyatt\\Portfolio\\Controller\\Cv', 'single',
        ['id' => 'cv.single']
    ]
];
