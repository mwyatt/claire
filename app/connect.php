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
}
catch (PDOException $error) {

	// Mask Connection Error
	echo '<h1>Unable to Connect to Database</h1>';
	exit;
}

/*
// Example SQL Statement
$STH = $DBH->query(
	"SELECT `id`, `status`"
	. " FROM content"
	//. " WHERE id = '1'"
);
	
	
echo '<pre>';
print_r ($STH->rowCount());
echo '</pre>';
exit;	*/