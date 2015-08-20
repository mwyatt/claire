<?php

$routes['home'] = [
    'mux/type' => 'get',

    // bad
    'mux/path' => '//',
    'mux/controller/method' => ['OriginalAppName\\Controller\\Index', 'home'],
    'mux/options' => []
];
