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

try {	

	$user = new User($DBH);

	$user->setEmail('martin.wyatt@gmail.com');
	$user->setPassword('123');

	// Install Tables
	require_once('app/cc/sql-table.php');

	// Add Test Data
	require_once('app/cc/sql-tabledata.php');	

	// Create installed.txt
	if ($fileHandle = fopen('installed.txt', 'w')) {
		$route->home();
	}

} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Website</h1>';
	echo $e;
	
}