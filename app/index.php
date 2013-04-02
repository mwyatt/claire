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


// Controller
// ============================================================================

$controller = new Controller($database, $config);

if ($controller->load($config->getUrl(0))) {
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
