<?php


$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index']
));

$routes->add('search', new Symfony\Component\Routing\Route(
	'/search/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index::search']
));

// doing
$routes->add('result-all', new Symfony\Component\Routing\Route(
	'/result/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::all']
));

$routes->add('result-year', new Symfony\Component\Routing\Route(
	'/result/{year}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::year']
));

$routes->add('result-year-division', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::division']
));

$routes->add('result-year-division-merit', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/merit/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::merit']
));

$routes->add('result-year-division-league', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/league/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::league']
));

$routes->add('result-year-division-merit-double', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/merit-double/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::meritDouble']
));

$routes->add('contentAll', new Symfony\Component\Routing\Route(
	'/{type}/',
	['controller' => 'OriginalAppName\\Controller\\Content']
));

$routes->add('contentSingle', new Symfony\Component\Routing\Route(
	'/{type}/{slug}/',
	['controller' => 'OriginalAppName\\Controller\\Content']
));
