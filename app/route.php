<?php


$routes->add('single', new Symfony\Component\Routing\Route(
	'/{slug}/',
	['controller' => 'OriginalAppName\\Controller\\Content']
));


$routes->add('read', new Symfony\Component\Routing\Route(
	'/asset/{path}',
	['controller' => 'OriginalAppName\\Controller\\Asset'],
	['path' => '.+']
));
