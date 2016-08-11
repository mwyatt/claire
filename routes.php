<?php

return [
    [
        'get', '/',
        '\\Mwyatt\\Claire\\Controller', 'home',
        ['id' => 'home']
    ],
    [
        'get', '/admin/',
        '\\Mwyatt\\Claire\\Admin\\Controller', 'home',
        ['id' => 'admin.home']
    ],
    [
        'get', '/:slug/',
        '\\Mwyatt\\Claire\\Controller\\Post', 'single',
        ['id' => 'post.single']
    ],
    [
        'get', '/admin/logout/',
        '\\Mwyatt\\Claire\\Admin\\Controller', 'logout',
        ['id' => 'admin.logout']
    ],
    [
        'post', '/admin/',
        '\\Mwyatt\\Claire\\Admin\\Controller', 'login'
    ],
    [
        'get', '/admin/:slug/',
        '\\Mwyatt\\Claire\\Admin\\Controller\\Post', 'single',
        ['id' => 'admin.post.single']
    ],
    [
        'post', '/admin/:slug/',
        '\\Mwyatt\\Claire\\Admin\\Controller\\Post', 'persist'
    ],
    [
        'get', '/cv/:name/',
        '\\Mwyatt\\Claire\\Controller\\Cv', 'single',
        ['id' => 'cv.single']
    ]
];
