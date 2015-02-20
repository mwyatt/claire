<?php

$routes['home'] = [
    'mux/type' => 'get',

    // bad
    'mux/path' => '//',
    'mux/controller/method' => ['OriginalAppName\\Site\\Mwyatt\\Controller\\Index', 'home'],
    'mux/options' => []
];
$routes['project/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/:type/:slug/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];

return;


$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Mwyatt\\Controller\\Index']
));

$routes->add('projectSingle', new Symfony\Component\Routing\Route(
	'/project/{slug}/',
	['controller' => 'OriginalAppName\\Site\\Mwyatt\\Controller\\Content']
));
