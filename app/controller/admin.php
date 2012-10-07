<?php

/**
 * Admin
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

 
$user = new User($database, $config);


// Log Out
// =============================================================================

if (array_key_exists('logout', $_GET)) {
	
	// Unset user Session
	$user->logout();
	
	// Redirect
	$route->homeAdmin();
	
}


// Login Attempt
// =============================================================================

if (array_key_exists('form_login', $_POST)) {
	
	if ($user->login())
		$user->setSession();
		
	$route->home('admin/');
	
}


// Logged In
// =============================================================================

if ($user->isLogged()) {

	// sub page
	if ($config->getUrl(2)) {
	
		$path = BASE_PATH . 'app/controller/' . $config->getUrl(1) . '-' . $config->getUrl(2) . '.php';

		if (is_file($path))
			require_once($path);
		else
			$route->home('admin/');
			
	} else {
	
		$view->loadTemplate('admin-dashboard');
		
	}
	
	exit;
	
}


// Invalid Url
// =============================================================================

if ($config->getUrl(2))
	$route->home('admin/');


// View: admin-login.php
// =============================================================================

$view->loadTemplate('admin-login');
	
/*
$view
	->registerObjects(array(
		$user
	))
	->loadTemplate('admin-login');
	*/

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	