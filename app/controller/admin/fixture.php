<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// Init
// ============================================================================

$ttfixture = new ttFixture($database, $config);

$ttfixture->generateAll();

// Form Submission
// ============================================================================

if (array_key_exists('form_card_new', $_POST)) {
	
	// if ($ttfixture->create($_POST))
	
	// 	$user->setFeedback('Player Created Successfully');
	
	// else
	
	// 	$user->setFeedback('Error Detected, Player has not been Created');
		
	// $route->current();
	
}


// Invalid Url
// ============================================================================

if ($config->getUrl(3))
	$route->home($config->getUrl(1) . '/' . $config->getUrl(2) . '/');

	
// View: admin/card/submit.php
// ============================================================================
		/*
$ttfixture->select();

$view
	->setObject(array($user, $ttfixture))
	->loadTemplate('admin/card/submit');*/