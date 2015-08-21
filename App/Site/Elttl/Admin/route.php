<?php

foreach (['division', 'team', 'player', 'venue', 'fixture'] as $entity) {
    $class = "OriginalAppName\\Site\\Elttl\\Admin\\Controller\\Tennis\\" . ucfirst($entity);
    $routes["admin/tennis/$entity/create"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/tennis/$entity/create/",
        'mux/controller/method' => [$class, 'single'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'post',
        'mux/path' => "/admin/tennis/$entity/create/",
        'mux/controller/method' => [$class, 'create'],
        'mux/options' => []
    ];
    $routes["admin/tennis/$entity/all"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/tennis/$entity/",
        'mux/controller/method' => [$class, 'all'],
        'mux/options' => []
    ];
    $routes["admin/tennis/$entity/single"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/tennis/$entity/:id/",
        'mux/controller/method' => [$class, 'single'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'post',
        'mux/path' => "/admin/tennis/$entity/:id/",
        'mux/controller/method' => [$class, 'update'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'delete',
        'mux/path' => "/admin/tennis/$entity/:id/",
        'mux/controller/method' => [$class, 'delete'],
        'mux/options' => []
    ];
}

// just all for now
$routes['admin/tennis/year/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/tennis/year/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Admin\\Controller\\Tennis\\Year', 'all'],
    'mux/options' => []
];

$routes['admin/system/tennis'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/system/tennis/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Admin\\Controller\\System\\Tennis', 'all'],
    'mux/options' => []
];

// content/types
$pairs = [
    'page' => 'OriginalAppName\\Admin\\Controller\\Content\\Page',
    'press' => 'OriginalAppName\\Admin\\Controller\\Content\\Press'
];
foreach ($pairs as $slug => $class) {
    $routes["admin/$slug/create"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/$slug/create/",
        'mux/controller/method' => [$class, 'single'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'post',
        'mux/path' => "/admin/$slug/create/",
        'mux/controller/method' => [$class, 'create'],
        'mux/options' => []
    ];
    $routes["admin/$slug/all"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/$slug/",
        'mux/controller/method' => [$class, 'all'],
        'mux/options' => []
    ];
    $routes["admin/$slug/single"] = [
        'mux/type' => 'get',
        'mux/path' => "/admin/$slug/:id/",
        'mux/controller/method' => [$class, 'single'],
        'mux/options' => []
    ];
    $routes[] = [
        'mux/type' => 'post',
        'mux/path' => "/admin/$slug/:id/",
        'mux/controller/method' => [$class, 'update'],
        'mux/options' => []
    ];
    $routes["admin/$slug/delete"] = [
        'mux/type' => 'get',
        'mux/path' => '/admin/content/delete/:id/',
        'mux/controller/method' => [$class, 'delete'],
        'mux/options' => []
    ];
}
