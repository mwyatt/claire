<?php

/**
 * Initiate Ajax
 * 
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

 
// Base Path
// ============================================================================

define('BASE_PATH', (string) (__DIR__ . '/'));


// AutoLoader
// ============================================================================

require_once(BASE_PATH . 'app/autoloader.php');

spl_autoload_register(array('AutoLoader', 'loadClass'));
spl_autoload_register(array('AutoLoader', 'loadModel'));

		
// Error Handling
// ============================================================================

$error = new Error($debug = 'yes');


// Database
// ============================================================================

$database = new Database();


// Session
// ============================================================================

$session = new Session();


// Config, Route
// ============================================================================

$config = new Config();
$config
	->setUrl();

$route = new Route();
$route
	->setObject(array($config));