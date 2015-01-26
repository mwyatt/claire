<?php

$routes->add('admin', new Symfony\Component\Routing\Route(
	'/admin/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Index']
));

$routes->add('adminContentAll', new Symfony\Component\Routing\Route(
	'/admin/content/{type}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));

$routes->add('adminContentCreate', new Symfony\Component\Routing\Route(
	'/admin/content/{type}/create/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));

$routes->add('adminContentSingle', new Symfony\Component\Routing\Route(
	'/admin/content/{type}/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Content']
));

$routes->add('adminOptionAll', new Symfony\Component\Routing\Route(
	'/admin/settings/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Option']
));

$routes->add('adminUserAll', new Symfony\Component\Routing\Route(
	'/admin/user/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
));

$routes->add('adminUserCreate', new Symfony\Component\Routing\Route(
	'/admin/user/create/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
));

$routes->add('adminUserSingle', new Symfony\Component\Routing\Route(
	'/admin/user/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\User']
));

// forgot password, perhaps remove?
$routes->add('adminAjaxForgotPassword', new Symfony\Component\Routing\Route(
	'/admin/ajax/forgot-password/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\ForgotPassword']
));

$routes->add('adminAjaxContentGenerateSlug', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/generate-slug/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content']
));

// ajax/option
$routes->add('adminAjaxOptionRead', new Symfony\Component\Routing\Route(
	'/admin/ajax/option/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Option']
));
$routes->add('adminAjaxOptionCreate', new Symfony\Component\Routing\Route(
	'/admin/ajax/option/create/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Option']
));
$routes->add('adminAjaxOptionDelete', new Symfony\Component\Routing\Route(
	'/admin/ajax/option/delete/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Option']
));
$routes->add('adminAjaxOptionUpdate', new Symfony\Component\Routing\Route(
	'/admin/ajax/option/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Option']
));

// ajax/content/meta
$routes->add('adminAjaxContentMetaAll', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/meta/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content\\Meta']
));
$routes->add('adminAjaxContentMetaCreate', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/meta/create/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content\\Meta']
));
$routes->add('adminAjaxContentMetaDelete', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/meta/delete/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content\\Meta']
));
$routes->add('adminAjaxContentMetaUpdate', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/meta/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content\\Meta']
));

// ajax/content/single
$routes->add('adminAjaxContentSingle', new Symfony\Component\Routing\Route(
	'/admin/ajax/content/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Ajax\\Content']
));

// validate and show form
$routes->add('adminForgotPassword', new Symfony\Component\Routing\Route(
	'/admin/forgot-password/{key}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\ForgotPassword']
));
