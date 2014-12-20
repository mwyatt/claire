<?php


$routes->add('adminAjaxPlayerRead', new Symfony\Component\Routing\Route(
	'/admin/ajax/player/{id}/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Tennis']
));


$routes->add('adminAjaxPlayerCreate', new Symfony\Component\Routing\Route(
	'/admin/ajax/player/create/',
	['controller' => 'OriginalAppName\\Admin\\Controller\\Tennis']
));
