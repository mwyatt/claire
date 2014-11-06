<?php


$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index::home'],
	['_method' => 'GET']
));


$routes->add('content-all', new Symfony\Component\Routing\Route(
	'/{type}/',
	['controller' => 'OriginalAppName\\Controller\\Content::all'],
	['_method' => 'GET']
));


$routes->add('content-single', new Symfony\Component\Routing\Route(
	'/{type}/{slug}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Content::single'],
	['_method' => 'GET']
));


$routes->add('result-all', new Symfony\Component\Routing\Route(
	'/result/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::all'],
	['_method' => 'GET']
));


$routes->add('result-year', new Symfony\Component\Routing\Route(
	'/result/{year}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::year'],
	['_method' => 'GET']
));


$routes->add('result-year-division', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::division'],
	['_method' => 'GET']
));


return $routes;
