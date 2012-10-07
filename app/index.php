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

$view = new View($database->dbh);


// Admin Area
// =============================================================================

if ('admin' == $config->getUrl(1)) {
	require_once(BASE_PATH . '/app/admin.php');
	exit;
}

// Controller
// =============================================================================

if ($config->getUrl(1)) {
	//$autoloader->loadController($config->getUrl(1));
	require_once($file);
	exit;
}


// Content Page
// =============================================================================

if ($config->getUrl(1) && !$config->getUrl(2)) {

	// Objects
	$content = new Content($database->dbh);	
	
	// Objects Methods
	if ($content->selectTitle($config->getUrl(1), 1)) {
	
		$content->setAttached('300x160');
	
		// View: page
		require_once('app/view/page.php');
		exit;		
	}
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
	
$view->loadCached('home');
	
$posts = new Content($database->dbh, 'post');
$posts->select(5);	

//$ads = new Ads($database->dbh);
//$ads->select('cover')->shuffle();

//$projects = new Content($database->dbh, 'project');	
//$projects->select(2);

$view->registerObjects(array($posts))
	->loadTemplate('home');





























