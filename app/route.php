<?php


$routes->add('asset', new Symfony\Component\Routing\Route(
	'/asset/{path}',
	['controller' => 'OriginalAppName\\Controller\\Asset'],
	['path' => '.+']
));
