<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// initialise 

$ttPlayer = new ttPlayer($database, $config);
$ttDivision = new ttDivision($database, $config);

$ttPlayer
	->setObject($session)
	->setObject($mainUser);

// (POST) update

if (array_key_exists('form_player_update', $_POST)) {

	$ttPlayer->update($_POST);
		
	$route->current();
	
}

// (POST) new

if (array_key_exists('form_player_new', $_POST)) {
	
	$ttPlayer->create($_POST);

	$route->homeAdmin('player/');
	
}

// (GET) update

if (array_key_exists('update', $_GET)) {

	if (! $ttPlayer->readById($_GET['update']))
		$route->current();

	$ttDivision->read();
	$ttTeam = new ttTeam($database, $config);
	$ttTeam->readByDivision($ttPlayer->get('division_id'));

	$view	
		->setObject($ttDivision)
		->setObject($ttTeam)
		->setObject($ttPlayer)
		->loadTemplate('admin/player/update');
		
}

// (GET) delete

if (array_key_exists('delete', $_GET)) {
	
	$ttPlayer->deleteById($_GET['delete']);
		
}

// next page

if ($config->getUrl(3)) {

	if ($config->getUrl(3) == 'new') {

		$ttDivision->read();

		$view->setObject($ttDivision);

	}

	$view->loadTemplate($config->getUrl(1) . '/' . $config->getUrl(2) . '/' . $config->getUrl(3));	
	
}

// invalid url

if ($config->getUrl(3))
	$route->home('admin/' . $config->getUrl(2) . '/');

// view 	
	
$ttPlayer->read();

$view
	->setObject(array($mainUser, $ttPlayer))
	->loadTemplate('admin/player/list');