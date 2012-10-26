<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// initialise 

$ttPlayer = new ttPlayer($database, $config);

// delete

if (array_key_exists('form_player_new', $_POST)) {
	
	$ttPlayer
		->setObject($mainUser)
		->create();
		
	$route->current();
	
}

// new


if (array_key_exists('form_player_new', $_POST)) {
	
	$ttPlayer
		->setObject($mainUser)
		->create($_POST);
		
	$route->current();
	
}

// next page

if ($config->getUrl(2))
	$view->loadTemplate($config->getUrl(0) . '/' . $config->getUrl(1) . '/' . $config->getUrl(2));	

// invalid url

if ($config->getUrl(2))
	$route->home('admin/' . $config->getUrl(1) . '/');

// view 	
	
$ttPlayer->select();

$view
	->setObject(array($mainUser, $ttPlayer))
	->loadTemplate('admin/player/list');