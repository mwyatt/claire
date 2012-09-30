<?php

/**
 * Core /cc/ Logic
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

// CC Models
// -----------------------------------------------------------------------------
require_once('app/cc/model/cccontent.php');


$user = new User($DBH);

$menu = new Menu($DBH, $config->getUrlBase(), $config->getUrl());


// Log Out
// -----------------------------------------------------------------------------
if (isset($_GET['logout'])) {
	
	// Unset Session
	$user->logout();
	
	// Redirect
	$route->home('cc/');
}


// Logged In
// -----------------------------------------------------------------------------
if ($user->isLogged()) {

	if ($config->getUrl(2)) {
	
		// Controller
		if ($file = $controller->find('app/cc/controller/'.$config->getUrl(2).'/index')) {
			require_once($file);
			exit;
		} else {
			$route->home('cc/');
		}
	} else {
	
		// Dashboard
		require_once('app/cc/controller/index.php');
		exit;	
	}
	
} 


// Login Attempt
// -----------------------------------------------------------------------------
if (array_key_exists('form_login', $_POST)) {
	
	if ($user->login()) {
		$user->setSession();
	}
	
	$route->home('cc/');
	
}


// Invalid Url
// -----------------------------------------------------------------------------
if ($config->getUrl(2)) {
echo 'here';
	$route->home('cc/');
	
}


// view: login
// -----------------------------------------------------------------------------
require_once('app/cc/view/login.php');