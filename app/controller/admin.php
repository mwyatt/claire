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

 
$user = new MainUser($database, $config);

$view->setObject(array($user));



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
	if ($config->getUrl(1)) {
	
		$path = BASE_PATH . 'app/controller/' . $config->getUrl(0) . '/' . $config->getUrl(1) . '.php';
	
		if (is_file($path))
			require_once($path);
		else
			$route->home('admin/');
			
	} else {
	
		// view/admin/dashboard.php
		$view->loadTemplate('admin/dashboard');	
	
	}
	
	exit;
	
}


// Invalid Url
// =============================================================================

if ($config->getUrl(1))
	$route->home('admin/');


// View: admin/login.php
// =============================================================================

$view->loadTemplate('admin/login');

//$view->loadTemplate('admin/form-new-team');
	
/*
$view
	->registerObjects(array(
		$user
	))
	->loadTemplate('admin-login');
	*/

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	