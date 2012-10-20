<?php

/**
 * Install the Database
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

 
// look for installed.txt
if (is_file(BASE_PATH . 'installed.txt')) {

	// delete installed.txt
	unlink(BASE_PATH . 'installed.txt');
	
	// refresh database
	$database->dbh->query("DROP DATABASE mvc_002"); 
	$database->dbh->query("CREATE DATABASE mvc_002");
	
	$route->home('?install');

} else {
	
	// try installation
	try {	

		$mainuser = new mainUser($database, $config);

		require_once(BASE_PATH . '/install-table.php');
		require_once(BASE_PATH . '/install-tabledata.php');
		
		// create installed.txt
		$file = fopen(BASE_PATH . 'installed.txt', 'w');
			
	} catch (PDOException $e) { 

		// Handle Exception
		echo '<h1>Exception while Installing Website</h1>';
		echo $e;
		
	}		
	
	$route->home();
	
}