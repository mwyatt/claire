<?php

return [
    [
        'get', '/',
        '\\Mwyatt\\Claire\\Controller', 'home',
        ['id' => 'home']
    ],
    [
        'get', '/:slug/',
        '\\Mwyatt\\Claire\\Controller\\Post', 'single',
        ['id' => 'post.single']
    ]
];
