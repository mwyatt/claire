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
// =============================================================================

define('BASE_PATH', realpath('.'));


// AutoLoader
// =============================================================================

require_once(BASE_PATH . '/app/autoloader.php');
$load = new AutoLoader();

// register loading methods
spl_autoload_register(array('AutoLoader', 'loadClass'));
spl_autoload_register(array('AutoLoader', 'loadController'));
spl_autoload_register(array('AutoLoader', 'loadModel'));
spl_autoload_register(array('AutoLoader', 'loadError'));

		
// Error Handling
// =============================================================================

$error = new Error($debug = 'yes');

	
// Database / Session
// =============================================================================

require_once(BASE_PATH . '/app/database.php');
require_once(BASE_PATH . '/app/session.php');


// Config, Controller & Route
// =============================================================================

$config = new Config();

$config
	->setUrl()
	->setUrlBase();

$route = new Route($config->getUrlBase(), $config->getUrl());	
	
			
// Install
// =============================================================================

if (array_key_exists('flush', $_GET)) {

	// look for installed.txt
	if (is_file(BASE_PATH . 'installed.txt')) {
	
		// delete installed.txt
		unlink(BASE_PATH . 'installed.txt');
		
		// refresh database
		$DBH->query("DROP DATABASE mvc_002"); 
		$DBH->query("CREATE DATABASE mvc_002");
		
		// redirect
		$route->home('?flush');
	
	} else {
	
		// install database
		require_once(BASE_PATH . '/app/database.php');
		require_once(BASE_PATH . '/install.php');
		
		// redirect
		$route->home();
	}
	
}


// App
// =============================================================================

require_once(BASE_PATH . '/app/index.php');
exit;