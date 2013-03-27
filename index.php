<?php

/**
 * Initiate Application
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
spl_autoload_register(array('AutoLoader', 'load'));

		
// Error Handling
// ============================================================================

$error = new Error('yes');


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
	
			
// Install
// ============================================================================

if (array_key_exists('install', $_GET)) {

	require_once(BASE_PATH . 'install.php');
	
}


// App
// ============================================================================

require_once(BASE_PATH . '/app/index.php');
exit;