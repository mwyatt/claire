<?php


$routes->add('admin', new Symfony\Component\Routing\Route(
	'/admin/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Index::index'],
	['_method' => 'GET']
));


$routes->add('admin-content-all', new Symfony\Component\Routing\Route(
	'/admin/{type}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content::all'],
	['_method' => 'GET']
));


$routes->add('admin-content-single', new Symfony\Component\Routing\Route(
	'/admin/{type}/{slug}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content::single'],
	['_method' => 'GET']
));


$routes->add('admin-ajax-player-read', new Symfony\Component\Routing\Route(
	'/admin/ajax/player/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Tennis'],
	['_method' => 'GET']
));


$routes->add('admin-ajax-player-create', new Symfony\Component\Routing\Route(
	'/admin/ajax/player/create/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Tennis'],
	['_method' => 'GET']
));
