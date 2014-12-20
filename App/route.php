<?php


// asset
$routes->add('assetSingle', new Symfony\Component\Routing\Route(
	'/asset/{path}',
	['controller' => 'OriginalAppName\\Controller\\Asset'],
	['path' => '.+']
));

// content all
$routes->add('contentAll', new Symfony\Component\Routing\Route(
	'/{type}/',
	['controller' => 'OriginalAppName\\Controller\\Content']
));

// content single
$routes->add('contentSingle', new Symfony\Component\Routing\Route(
	'/{type}/{slug}/',
	['controller' => 'OriginalAppName\\Controller\\Content']
));
