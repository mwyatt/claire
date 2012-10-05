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

	$user
		->setEmail('martin.wyatt@gmail.com')
		->setPassword('123');

	require_once(BASE_PATH . '/install-table.php');
	require_once(BASE_PATH . '/install-tabledata.php');
	
	// create installed.txt
	$file = fopen(BASE_PATH . 'installed.txt', 'w');
		
} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Website</h1>';
	echo $e;
	
}