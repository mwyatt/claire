<?php


$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index::home'],
	['_method' => 'GET']
));


$routes->add('content-all', new Symfony\Component\Routing\Route(
	'/{type}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Content::all'],
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


return $routes;

return [
	[
		'index',
		'/',
		''
	],
	[
		'post-all',
		'',
		''
	],
	[

	],
	[
		'result',
		'/result/',
		'OriginalAppName\\Site\\Elttl\\Controller\\Result::index'
	],
	[
		'result-year',
		'/result/{year}/',
		'OriginalAppName\\Site\\Elttl\\Controller\\Result::year'
	],
	[
		'result-year-division',
		'/result/{year}/{division}/',
		'OriginalAppName\\Site\\Elttl\\Controller\\Result::division'
	]
];
