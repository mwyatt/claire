<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// Init
// ============================================================================

$ttFixture = new ttFixture($database, $config);
$ttDivision = new ttDivision($database, $config);

$ttDivision->read();

$view->setObject(array($mainUser, $ttDivision, $ttFixture));


// Form Submission
// ============================================================================

if (array_key_exists('form_fixture_fulfill', $_POST)) {

	$ttFixture
		->fulfill($_POST);
		
	$route->current();		
	
}


// Sub Page
// ============================================================================

if ($config->getUrl(2)) {

	$view->loadTemplate($config->getUrl(0) . '/' . $config->getUrl(1) . '/' . $config->getUrl(2));

}


// Invalid URL
// ============================================================================

if ($config->getUrl(2)) {

	$route->home($config->getUrl(0) . '/' . $config->getUrl(1) . '/');
	
}


// View: admin/fixture/list.php
// ============================================================================
		
$ttFixture->read();

$view
	->setObject($ttFixture)
	->loadTemplate('admin/fixture/list');