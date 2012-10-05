<?php

/**
 * Interfaces with the PDO class to make a Connection
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
 

try {

	$credentials = array(
		'host' => 'localhost',
		'port' => '80',
		'basename' => 'mvc_002',
		'username' => 'root',
		'password' => '',
	);

	// Set Data Source Name
	$dataSourceName = 'mysql:host='.$credentials['host']
		.';dbname='.$credentials['basename'];
	
	// Connect
	$DBH = new PDO(
		$dataSourceName,
		$credentials['username'],
		$credentials['password']
	);
	
	// Set Error Mode
	$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
} catch (PDOException $error) {

	echo '<h1>Unable to Connect to Database: '
		. $credentials['basename']
		. '</h1>';
	exit;
	
}