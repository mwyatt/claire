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

$mainUser = new MainUser($database, $config);
$mainUser->setObject($session);

$view->setObject(array($mainUser));

// log out

if (array_key_exists('logout', $_GET)) {
	
	// Unset user Session
	$mainUser->logout();
	
	// Redirect
	$route->homeAdmin();
	
}

// login attempt

if (array_key_exists('form_login', $_POST)) {
	
	if ($mainUser->login())
		$mainUser->setSession();
		
	$route->home('admin/');
	
}

// logged in

if ($mainUser->isLogged()) {

	if ($config->getUrl(1)) {

		$path = BASE_PATH . 'app/controller/' . $config->getUrl(0) . '/' . $config->getUrl(1) . '.php';
	
		if ($mainUser->checkPermission($path))
			require_once($path);
		else
			$view->loadTemplate('admin/permission');	

	} else {

		// dashboard
	
		$view->loadTemplate('admin/dashboard');	
	
	}
	
}


// Invalid Url
// =============================================================================

if ($config->getUrl(1))
	$route->home('admin/');


// View: admin/login.php
// =============================================================================

$view->loadTemplate('admin/login');