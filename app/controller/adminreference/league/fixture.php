<?php

/**
 * @access 9
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// Init
// ============================================================================

$ttFixture = new ttFixture($database, $config);
$ttFixture
	->setObject($mainUser)
	->setObject($session);

$ttDivision = new ttDivision($database, $config);

$ttDivision->read();

$view->setObject(array($mainUser, $ttDivision, $ttFixture, $session));

// Form Submission
// ============================================================================

if (array_key_exists('form_fixture_fulfill', $_POST)) {

	$ttFixture->fulfill($_POST);
	$route->current();		
	
}


// Sub Page
// ============================================================================

if ($config->getUrl(3)) {

	$view->loadTemplate($config->getUrl(0) . '/' . $config->getUrl(1) . '/' . $config->getUrl(2) . '/' . $config->getUrl(3));

}


// View: admin/fixture/list.php
// ============================================================================
		
$ttFixture->read();

$view
	->setObject($ttFixture)
	->loadTemplate('admin/league/fixture/list');