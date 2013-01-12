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

	if (! $ttTeam->readById($_GET['update']))
		$route->current();

	$ttVenue = new ttVenue($database, $config);
	$ttVenue->read();
	$ttSecretary = new ttSecretary($database, $config);
	$ttSecretary->read();
	$ttDivision->read();

	$view
		->setObject($ttDivision)
		->setObject($ttVenue)
		->setObject($ttSecretary)
		->setObject($ttTeam)
		->loadTemplate('admin/league/team/update');

}

// (GET) delete

if (array_key_exists('delete', $_GET)) {
	
	$ttTeam->deleteById($_GET['delete']);
		
}

// next page

if ($config->getUrl(3)) {

	// new

	if ($config->getUrl(3) == 'new') {

		$ttVenue = new ttVenue($database, $config);
		$ttVenue->read();
		$ttDivision->read();

		$view
			->setObject($ttTeam)
			->setObject($ttDivision)
			->setObject($ttVenue);

	}

	$view->loadTemplate($config->getUrl(1) . '/' . $config->getUrl(2) . '/' . $config->getUrl(3));	
	
}

// invalid url

if ($config->getUrl(3))
	$route->home('admin/' . $config->getUrl(2) . '/');

// view 	
	
$ttTeam->read();

$view
	->setObject($ttTeam)
	->loadTemplate('admin/league/team/list');