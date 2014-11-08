<?php


$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index::home']
));


$routes->add('search', new Symfony\Component\Routing\Route(
	'/search/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index::search']
));


$routes->add('asset', new Symfony\Component\Routing\Route(
	'/app/site/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Random::search']
));


$routes->add('content-all', new Symfony\Component\Routing\Route(
	'/{type}/',
	['controller' => 'OriginalAppName\\Controller\\Content::all']
));


$routes->add('content-single', new Symfony\Component\Routing\Route(
	'/{type}/{slug}/',
	['controller' => 'OriginalAppName\\Controller\\Content::single']
));


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
