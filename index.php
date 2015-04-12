<?php

namespace OriginalAppName;

use OriginalAppName;


/**
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 


/**
 * constants defined
 */
include 'constant.php';

// app config
$configApp = include APP_PATH . 'config' . EXT;


/**
 * get error reporting in asap
 * whether it reports errors is determined by config.json
 */
$error = new OriginalAppName\Error($configApp['errorReporting']);


/**
 * boot
 */
include APP_PATH . 'ini' . EXT;
include APP_PATH . 'index' . EXT;
