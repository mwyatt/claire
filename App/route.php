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

// forgot password, perhaps remove?
$routes->add('ajaxAdminUserForgotPassword', new Symfony\Component\Routing\Route(
	'/ajax/admin/user/forgot-password/',
	['controller' => 'OriginalAppName\\Controller\\Ajax\\Admin\\User']
));

// validate
$routes->add('validate', new Symfony\Component\Routing\Route(
	'/validate/',
	['controller' => 'OriginalAppName\\Controller\\Validate']
));
