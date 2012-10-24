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

$ttDivision->select();

$view->setObject(array($mainUser, $ttDivision, $ttFixture));


// Form Submission
// ============================================================================

if (array_key_exists('form_fixture_fulfill', $_POST)) {
	
	if ($ttFixture->fulfill($_POST))
		
		$mainUser->setFeedback('Fixture Fulfilled Successfully');
	
	else
	
		$mainUser->setFeedback('Error Detected, Fixture has not been Fulfilled');
		
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
		
$view->loadTemplate('admin/fixture/list');