<?php

$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Mwyatt\\Controller\\Index']
));

$routes->add('skillsAll', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Mwyatt\\Controller\\Skill']
));

$routes->add('projectSingle', new Symfony\Component\Routing\Route(
	'/project/{slug}/',
	['controller' => 'OriginalAppName\\Site\\Mwyatt\\Controller\\Content']
));
