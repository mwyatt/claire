<?php

$routes['home'] = [
    'mux/type' => 'get',

    // bad
    'mux/path' => '//',
    'mux/controller/method' => ['OriginalAppName\\Site\\Claire\\Controller\\Index', 'home'],
    'mux/options' => []
];

$routes['search'] = [
    'mux/type' => 'get',
    'mux/path' => '/search/',
    'mux/controller/method' => ['OriginalAppName\\Site\\Claire\\Controller\\Search', 'primary'],
    'mux/options' => []
];
