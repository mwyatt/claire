<?php

/**
 * Base Application Logic
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */


// View
// ============================================================================
$hi = 'hello';
$view = new View($database, $config);
$view
	->setObject($session);

$config
	->setObject($view);

$controller = new Controller($config);


// Controller
// ============================================================================

if ($controller->load()) {
	exit;
} else {
	// $view->loadCached('home');
	$posts = new mainContent($database, $config);
	$posts->select(5);	
	$ads = new Ads($database->dbh);
	$ads->select('cover')->shuffle();
	$projects = new Content($database->dbh, 'project');	
	$projects->select(2);
	$view->loadTemplate('home');
}