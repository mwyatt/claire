<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// initialise 

$mainMedia = new mainMedia($database, $config);
$mainMedia
	->setObject($view)
	->setObject($session)
	->setObject($mainUser);

// next page

if ($config->getUrl(2)) {

	$path = BASE_PATH . 'app/controller/admin/media/' . $config->getUrl(2) . '.php';

	if (is_file($path))
		require_once($path);
	
}
 
// invalid url

if ($config->getUrl(2))
	$route->home('admin/media/');

// upload attempt

if (array_key_exists('form_media_upload', $_POST)) {

	$mainMedia->upload($_FILES);
	$route->home('admin/media/');	
	
}

// (GET) delete

if (array_key_exists('delete', $_GET)) {
	
	$mainMedia->deleteById($_GET['delete']);
		
}
  
$mainMedia->read();

$view
	->setObject($mainMedia)
	->loadTemplate('admin/media/list');
