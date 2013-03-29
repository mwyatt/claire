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

$config
	->setObject($view);

$controller = new Controller($config);


// Controller
// ============================================================================

$controller->load();

// if ($config->getUrl(0)) {
// 	$path = BASE_PATH . 'app/controller/' . $config->getUrl(0) . '.php';
// 	if (is_file($path)) require_once($path);
// }


// // Content Page
// // ============================================================================

// if ($config->getUrl(0) == 'page') {
// 	$mainContent = new mainContent($database, $config);	
// 	if ($mainContent->readByTitleSlug($config->getUrl(1))) {
// 		$view
// 			->setObject($mainContent)
// 			->setMeta(array(
// 				'title' => $mainContent->get('meta_title'),
// 				'keywords' => $mainContent->get('meta_keywords'),
// 				'description' => $mainContent->get('meta_description')
// 			))
// 			->loadTemplate('page');
// 	}
// }


// // Invalid URL
// // ============================================================================

// if ($config->getUrl(0)) {
// 	$route->home();
// }


// // Homepage
// // ============================================================================
	
// // exit('Front end Under Construction');

// //$view->loadCached('home');
	
// // $posts = new mainContent($database, $config);
// // $posts->select(5);	

// //$ads = new Ads($database->dbh);
// //$ads->select('cover')->shuffle();

// //$projects = new Content($database->dbh, 'project');	
// //$projects->select(2);

// $view->loadTemplate('home');