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

$user = new User($DBH);

$menu = new Menu($DBH, $config->getUrlBase(), $config->getUrl());


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
	
		// controller
		if ($file = $load->controller($config->getUrl(2)))
			require_once($file);
		else
			$route->home('admin/');
		
	} else {
	
		if ($file = $load->view('admin-dashboard'))
			require_once($file);	
		
	}
	
	exit;
	
} 


// Invalid Url
// =============================================================================

if ($config->getUrl(2)) $route->home('admin/');


// View: login.php
// =============================================================================

if ($file = $load->view('admin-login'))
	require_once($file);

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	