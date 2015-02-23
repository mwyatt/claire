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

// user
$class = 'OriginalAppName\\Admin\\Controller\\User';
$routes['admin/user/create'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/user/create/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/user/create/',
    'mux/controller/method' => [$class, 'create'],
    'mux/options' => []
];
$routes['admin/user/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/user/',
    'mux/controller/method' => [$class, 'all'],
    'mux/options' => []
];
$routes['admin/user/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/user/:id/',
    'mux/controller/method' => [$class, 'single'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'post',
    'mux/path' => '/admin/user/:id/',
    'mux/controller/method' => [$class, 'update'],
    'mux/options' => []
];
$routes[] = [
    'mux/type' => 'delete',
    'mux/path' => '/admin/user/:id/',
    'mux/controller/method' => [$class, 'delete'],
    'mux/options' => []
];

// crud-option
$routes['admin/option/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/settings/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Option', 'all'],
    'mux/options' => []
];



// ajax-option
$routes['admin/ajax/option/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/settings/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Option', 'all'],
    'mux/options' => []
];
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

// ajax-content
$routes[] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/ajax/content/generate-slug/',
    'mux/controller/method' => ['OriginalAppName\\Admin\\Controller\\Ajax\\Content', 'generateSlug'],
    'mux/options' => []
];

// crud content
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
$routes['admin/content/delete'] = [
    'mux/type' => 'get',
    'mux/path' => '/admin/content/delete/:id/',
    'mux/controller/method' => [$class, 'delete'],
    'mux/options' => []
];



return;









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
