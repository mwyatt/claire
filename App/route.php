<?php


/**
 * generic app wide routes
 */
$routes['asset/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/asset/:path/',
    'mux/controller/method' => ['OriginalAppName\\Controller\\Asset', 'single'],
    'mux/options' => ['require' => ['path' => '.+']]
];

// content
$class = 'OriginalAppName\\Controller\\Content';
$routes['content/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/:type/',
    'mux/controller/method' => [$class, 'all'],
    'mux/options' => []
];
$routes['content/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/:type/:slug/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
