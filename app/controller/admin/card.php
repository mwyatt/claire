<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// Init
// ============================================================================

$ttDivision = new ttDivision($database, $config);
$ttFixture = new ttFixture($database, $config);


// Form Submission
// ============================================================================

if (array_key_exists('form_card_new', $_POST)) {
	
	$ttFixture
		->update($_POST);
	
}


// Invalid Url
// ============================================================================

if ($config->getUrl(3))
	$route->home($config->getUrl(1) . '/' . $config->getUrl(2) . '/');

	
// View: admin/card/submit.php
// ============================================================================
		
$ttDivision->select();

$view
	->setObject(array($user, $ttDivision, $ttFixture))
	->loadTemplate('admin/card/submit');