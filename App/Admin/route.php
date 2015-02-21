<?php

// login / dash
$routes['admin'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Index', 'admin'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Index', 'login'],
    'mux/options' => []
];

// forgot password init ajax
$routes['admin/ajax/user/forgot-password'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/user/forgot-password/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Ajax\\User', 'forgotPassword'],
    'mux/options' => []
];

// forgot password form and submission
$class = 'OriginalAppName\\Controller\\Admin\\User';
$routes['admin/user/forgot-password/key'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/forgot-password/:key/',
    'mux/controller/method' => [$class, 'forgotPassword'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/forgot-password/:key/',
    'mux/controller/method' => [$class, 'forgotPasswordSubmit'],
    'mux/options' => []
];

// content
// must be lower down because it will match things it shouldnt
$class = 'OriginalAppName\\Admin\\Controller\\Content';
$routes['admin/content/create'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/:type/create/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/:type/create/',
    'mux/controller/method' => [$class, 'create'],
    'mux/options' => []
];
$routes['admin/content/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/:type/',
    'mux/controller/method' => [$class, 'all'],
    'mux/options' => []
];
$routes['admin/content/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/:type/:id/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/:type/:id/',
    'mux/controller/method' => [$class, 'update'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'delete',
    'mux/path' => '/admin/:type/:id/',
    'mux/controller/method' => [$class, 'delete'],
    'mux/options' => []
];



return;



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
