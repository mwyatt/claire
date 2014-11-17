<?php


$routes->add('admin', new Symfony\Component\Routing\Route(
	'/admin/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Index']
));


$routes->add('adminContentAll', new Symfony\Component\Routing\Route(
	'/admin/content/{type}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));


$routes->add('adminContentSingle', new Symfony\Component\Routing\Route(
	'/admin/content/{type}/{slug}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));


$routes->add('adminUserAll', new Symfony\Component\Routing\Route(
	'/admin/user/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
));


$routes->add('adminUserSingle', new Symfony\Component\Routing\Route(
	'/admin/user/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
));
