<?php

$routes['home'] = [
    'mux/type' => 'get',

    // bad
    'mux/path' => '//',
    'mux/controller/method' => ['OriginalAppName\\Site\\Claire\\Controller\\Index', 'home'],
    'mux/options' => []
];
