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
// =============================================================================

$view = new View($database, $config);


// Controller
// =============================================================================

if ($config->getUrl(1)) {

	$path = BASE_PATH . 'app/controller/' . $config->getUrl(1) . '.php';

	if (is_file($path))
		require_once($path);
				
}


// Content Page
// =============================================================================

if ($config->getUrl(1) && !$config->getUrl(2)) {
/*
	// Objects
	$content = new Content($database->dbh);	
	
	// Objects Methods
	if ($content->selectTitle($config->getUrl(1), 1)) {
	
		$content->setAttached('300x160');
	
		// View: page
		require_once('app/view/page.php');
		exit;		
	}*/
}


// 404 Page
// =============================================================================

if ($config->getUrl(1)) {
	
	// Redirect
	header('HTTP/1.0 404 Not Found');
	require_once('app/view/404.php');
	exit;
}


// Homepage
// =============================================================================
	
//$view->loadCached('home');
	
$posts = new Content($database, $config, 'post');
$posts->select(5);	

//$ads = new Ads($database->dbh);
//$ads->select('cover')->shuffle();

//$projects = new Content($database->dbh, 'project');	
//$projects->select(2);

$view->registerObjects(array($posts))
	->loadTemplate('home');





























