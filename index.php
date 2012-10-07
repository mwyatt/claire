<?php

/**
 * Initiate Application
 * 
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
 
/*
<?php
echo '<pre>';
print_r ($);
echo '</pre>';
exit;
?>
*/ 
 

// Base Path
// =============================================================================

define('BASE_PATH', (string) (__DIR__ . '/'));


// AutoLoader
// =============================================================================

require_once(BASE_PATH . 'app/autoloader.php');

spl_autoload_register(array('AutoLoader', 'loadClass'));
spl_autoload_register(array('AutoLoader', 'loadModel'));

		
// Error Handling
// =============================================================================

$error = new Error($debug = 'yes');


// Database
// =============================================================================

$database = new Database();


// Session
// =============================================================================

$session = new Session();


// Config, Route
// =============================================================================

$config = new Config();

echo '<pre>';
print_r ($config);
echo '</pre>';
exit;

$route = new Config();		
	
			
// Install
// =============================================================================

if (array_key_exists('install', $_GET)) {

	// look for installed.txt
	if (is_file(BASE_PATH . 'installed.txt')) {
	
		// delete installed.txt
		unlink(BASE_PATH . 'installed.txt');
		
		// refresh database
		$database->dbh->query("DROP DATABASE mvc_002"); 
		$database->dbh->query("CREATE DATABASE mvc_002");
		
		// redirect
		$route->home('?install');
	
	} else {
	
		// install database
		require_once(BASE_PATH . 'app/database.php');
		require_once(BASE_PATH . 'install.php');
		
		// redirect
		$route->home();
	}
	
}


// App
// =============================================================================

require_once(BASE_PATH . '/app/index.php');
exit;