<?php

// login / dash
$routes['admin'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Index', 'admin'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Index', 'login'],
    'mux/options' => []
];

// forgot password init ajax
$routes['admin/ajax/user/forgot-password'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/user/forgot-password/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Ajax\\User', 'forgotPassword'],
    'mux/options' => []
];

// forgot password form and submission
$class = 'OriginalAppName\\Controller\\Admin\\User';
$routes['admin/user/forgot-password/key'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/user/forgot-password/:key/',
    'mux/controller/method' => [$class, 'forgotPassword'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/user/forgot-password/:key/',
    'mux/controller/method' => [$class, 'forgotPasswordSubmit'],
    'mux/options' => []
];

// classic crud(s)
// quick way to build route for simple cruds
foreach (['user'] as $entity) {
    $class = "OriginalAppName\\Admin\\Controller\\" . ucfirst($entity);
    $routes["admin/$entity/create"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/$entity/create/",
        'mux/controller/method' => [$class, 'single'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'post',
        'mux/path' => "/admin/$entity/create/",
        'mux/controller/method' => [$class, 'create'],
        'mux/options' => []
    ];
    $routes["admin/$entity/all"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/$entity/",
        'mux/controller/method' => [$class, 'all'],
        'mux/options' => []
    ];
    $routes["admin/$entity/single"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/$entity/:id/",
        'mux/controller/method' => [$class, 'single'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'post',
        'mux/path' => "/admin/$entity/:id/",
        'mux/controller/method' => [$class, 'update'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'delete',
        'mux/path' => "/admin/$entity/:id/",
        'mux/controller/method' => [$class, 'delete'],
        'mux/options' => []
    ];
}

// crud-option
$routes['admin/option/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/settings/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Option', 'all'],
    'mux/options' => []
];

// ajax-option
$class = 'OriginalAppName\\Admin\\Controller\\Ajax\\Option';
$routes['admin/ajax/option/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/option/',
    'mux/controller/method' => [$class, 'all'],
    'mux/options' => []
];
$routes['admin/ajax/option/create'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/option/create/',
    'mux/controller/method' => [$class, 'create'],
    'mux/options' => []
];
$routes['admin/ajax/option/delete'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/option/delete/',
    'mux/controller/method' => [$class, 'delete'],
    'mux/options' => []
];
$routes['admin/ajax/option/update'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/option/update/',
    'mux/controller/method' => [$class, 'update'],
    'mux/options' => []
];

// ajax-content-meta
$class = 'OriginalAppName\\Admin\\Controller\\Ajax\\Content\\Meta';
$routes['admin/ajax/content/meta/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/meta/',
    'mux/controller/method' => [$class, 'all'],
    'mux/options' => []
];
$routes['admin/ajax/content/meta/create'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/meta/create/',
    'mux/controller/method' => [$class, 'create'],
    'mux/options' => []
];
$routes['admin/ajax/content/meta/delete'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/meta/delete/',
    'mux/controller/method' => [$class, 'delete'],
    'mux/options' => []
];
$routes['admin/ajax/content/meta/update'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/meta/update/',
    'mux/controller/method' => [$class, 'update'],
    'mux/options' => []
];

// ajax-content
$routes[] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/generate-slug/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Ajax\\Content', 'generateSlug'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/generate-table-slugs/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Ajax\\Content', 'generateTableSlugs'],
    'mux/options' => []
];

// crud content
// must be lower down because it will match things it shouldnt
$class = 'OriginalAppName\\Admin\\Controller\\Content';
$routes['admin/content/create'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/:type/create/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/:type/create/',
    'mux/controller/method' => [$class, 'create'],
    'mux/options' => []
];
$routes['admin/content/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/:type/',
    'mux/controller/method' => [$class, 'all'],
    'mux/options' => []
];
$routes['admin/content/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/:type/:id/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/:type/:id/',
    'mux/controller/method' => [$class, 'update'],
    'mux/options' => []
];
$routes['admin/content/delete'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/content/delete/:id/',
    'mux/controller/method' => [$class, 'delete'],
    'mux/options' => []
];
