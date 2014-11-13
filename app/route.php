<?php


$routes->add('read', new Symfony\Component\Routing\Route(
	'/asset/{path}',
	['controller' => 'OriginalAppName\\Controller\\Asset'],
	['path' => '.+']
));
