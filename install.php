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

	// refresh database

	$database->dbh->query("DROP DATABASE " . Database::$credentials['basename']); 
	$database->dbh->query("CREATE DATABASE " . Database::$credentials['basename']);
	
	// delete installed.txt

	unlink(BASE_PATH . 'installed.txt');

	$route->current('?install');

} else {
	
	// try installation
	try {	

		$mainuser = new mainUser($database, $config);

		require_once(BASE_PATH . '/install-table.php');
		require_once(BASE_PATH . '/install-tabledata.php');
		
		// @remove fixture generation
		// $ttfixture = new ttFixture($database, $config);
		// $ttfixture->generateAll();

		// create installed.txt
		$file = fopen(BASE_PATH . 'installed.txt', 'w');
			
	} catch (PDOException $e) { 

		// Handle Exception
		echo '<h1>Exception while Installing Website</h1>';
		echo $e;
		
	}		
	
	$route->current();
	
}