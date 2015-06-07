<?php


$routes['home'] = [
    'mux/type' => 'get',

    // bad
    'mux/path' => '//',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Index', 'home'],
    'mux/options' => []
];


// $routes->add('home', new Symfony\Component\Routing\Route(
// 	'/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index']
// ));

// $routes->add('search', new Symfony\Component\Routing\Route(
// 	'/search/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index']
// ));

// $routes->add('resultAll', new Symfony\Component\Routing\Route(
// 	'/result/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
// ));

// $routes->add('resultYear', new Symfony\Component\Routing\Route(
// 	'/result/{year}/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
// ));

// $routes->add('resultYearDivision', new Symfony\Component\Routing\Route(
// 	'/result/{year}/{division}/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
// ));

// $routes->add('resultYearDivisionMerit', new Symfony\Component\Routing\Route(
// 	'/result/{year}/{division}/merit/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
// ));

// $routes->add('resultYearDivisionLeague', new Symfony\Component\Routing\Route(
// 	'/result/{year}/{division}/league/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
// ));

// $routes->add('resultYearDivisionMeritDouble', new Symfony\Component\Routing\Route(
// 	'/result/{year}/{division}/merit-double/',
// 	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
// ));
