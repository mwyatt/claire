<?php


$routes->add('admin', new Symfony\Component\Routing\Route(
	'/admin/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Index']
));


$routes->add('adminAjaxContentSingle', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content']
));


$routes->add('adminContentAll', new Symfony\Component\Routing\Route(
	'/admin/content/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));


$routes->add('adminContentSingle', new Symfony\Component\Routing\Route(
	'/admin/content/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));


// $routes->add('adminUserAll', new Symfony\Component\Routing\Route(
// 	'/admin/user/',
// 	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
// ));


// $routes->add('adminUserSingle', new Symfony\Component\Routing\Route(
// 	'/admin/user/{id}/',
// 	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
// ));

// forgot password, perhaps remove?
$routes->add('adminAjaxForgotPassword', new Symfony\Component\Routing\Route(
	'/admin/ajax/user/forgot-password/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\ForgotPassword']
));

// validate and show form
$routes->add('adminForgotPassword', new Symfony\Component\Routing\Route(
	'/admin/forgot-password/{key}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\ForgotPassword']
));
