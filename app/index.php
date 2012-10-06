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

/*$view = new View(
	$config->getUrlBase(),
	$config->getUrl()
);*/


$view = new View($DBH);


// Menu
// =============================================================================

$menu = new Menu(
	$DBH,
	$config->getUrlBase(),
	$config->getUrl()	
);


// Admin Area
// =============================================================================

if ('admin' == $config->getUrl(1)) {
	require_once(BASE_PATH . '/app/admin.php');
	exit;
}

// Controller
// =============================================================================

if ($config->getUrl(1)) {
	require_once($file);
	exit;
}


// Content Page
// =============================================================================

if ($config->getUrl(1) && !$config->getUrl(2)) {

	// Objects
	$content = new Content($DBH);	
	
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





























