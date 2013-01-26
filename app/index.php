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

$view = new View($database, $config);

$view
	->setObject($session);

// Controller
// ============================================================================

if ($config->getUrl(0)) {
	$path = BASE_PATH . 'app/controller/' . $config->getUrl(0) . '.php';
	if (is_file($path)) require_once($path);
}


// Content Page
// ============================================================================

if ($config->getUrl(0) && !$config->getUrl(1)) {
/*
	// Objects
	$content = new Content($database->dbh);	
	
	// Objects Methods
	if ($content->selectTitle($config->getUrl(0), 1)) {
	
		$content->setAttached('300x160');
	
		// View: page
		require_once('app/view/page.php');
		exit;		
	}*/
}


// Invalid URL
// ============================================================================

if ($config->getUrl(0)) {
	$route->home();
}


// Homepage
// ============================================================================
	
// exit('Front end Under Construction');

//$view->loadCached('home');
	
// $posts = new mainContent($database, $config);
// $posts->select(5);	

//$ads = new Ads($database->dbh);
//$ads->select('cover')->shuffle();

//$projects = new Content($database->dbh, 'project');	
//$projects->select(2);

$view->loadTemplate('home');