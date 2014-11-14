<?php

$routes->add('home', new Symfony\Component\Routing\Route(
	'/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index']
));

$routes->add('search', new Symfony\Component\Routing\Route(
	'/search/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Index::search']
));

$routes->add('resultAll', new Symfony\Component\Routing\Route(
	'/result/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::all']
));

$routes->add('resultYear', new Symfony\Component\Routing\Route(
	'/result/{year}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::year']
));

$routes->add('resultYearDivision', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result::division']
));

$routes->add('resultYearDivisionMerit', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/merit/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
));

$routes->add('resultYearDivisionLeague', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/league/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
));

$routes->add('resultYearDivisionMeritDouble', new Symfony\Component\Routing\Route(
	'/result/{year}/{division}/merit-double/',
	['controller' => 'OriginalAppName\\Site\\Elttl\\Controller\\Result']
));
