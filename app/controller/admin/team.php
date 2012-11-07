<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// initialise 

$ttTeam = new ttTeam($database, $config);
$ttDivision = new ttDivision($database, $config);

$ttTeam->setObject($mainUser);

// (POST) update

if (array_key_exists('form_team_update', $_POST)) {

	$ttTeam->update($_POST);
		
	$route->current();
	
}

// (POST) new

if (array_key_exists('form_team_new', $_POST)) {
	
	$ttTeam->create($_POST);
		

	$route->homeAdmin('team/');
	
}

// (GET) update

if (array_key_exists('update', $_GET)) {

	if (! $ttTeam->selectById($_GET['update']))
		$route->current();

	$ttDivision->select();
	$ttTeam = new ttTeam($database, $config);
	$ttTeam->readByDivision($ttTeam->get('division_id'));

	$view	
		->setObject($ttDivision)
		->setObject($ttTeam)
		->setObject($ttTeam)
		->loadTemplate('admin/team/update');
		
}

// (GET) delete

if (array_key_exists('delete', $_GET)) {
	
	$ttTeam->deleteById($_GET['delete']);
		
}

// next page

if ($config->getUrl(2)) {

	if ($config->getUrl(2) == 'new') {

		$ttDivision->select();

		$view->setObject($ttDivision);

	}

	$view->loadTemplate($config->getUrl(0) . '/' . $config->getUrl(1) . '/' . $config->getUrl(2));	
	
}

// invalid url

if ($config->getUrl(2))
	$route->home('admin/' . $config->getUrl(1) . '/');

// view 	
	
$ttTeam->select();

$view
	->setObject(array($mainUser, $ttTeam))
	->loadTemplate('admin/team/list');