<?php


$routes['home'] = [
    'mux/type' => 'get',

    // bad
    'mux/path' => '//',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Index', 'home'],
    'mux/options' => []
];

$routes['result/year/all'] = [
    'mux/type' => 'get',
    'mux/path' => '/result/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Result', 'yearAll'],
    'mux/options' => []
];

$routes['result/year/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/result/:yearName/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Result', 'yearSingle'],
    'mux/options' => []
];

$routes['result/year/division/single'] = [
    'mux/type' => 'get',
    'mux/path' => '/result/:yearName/:divisionName/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Result', 'yearDivisionSingle'],
    'mux/options' => []
];

$routes['result/year/division/league'] = [
    'mux/type' => 'get',
    'mux/path' => '/result/:yearName/:divisionName/league/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Result', 'yearDivisionLeague'],
    'mux/options' => []
];

$routes['result/year/division/merit'] = [
    'mux/type' => 'get',
    'mux/path' => '/result/:yearName/:divisionName/merit/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Result', 'yearDivisionMerit'],
    'mux/options' => []
];

$routes['result/year/division/merit-doubles'] = [
    'mux/type' => 'get',
    'mux/path' => '/result/:yearName/:divisionName/merit-doubles/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Elttl\\Controller\\Result', 'yearDivisionMeritDoubles'],
    'mux/options' => []
];
