

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
	->setObject($session)
	->setObject($mainUser);

// upload attempt

if (array_key_exists('form_media_upload', $_POST)) {

	$mainMedia->upload($_FILES);
	$route->home('admin/media/');	
	
}
  
$mainMedia->read();

$view
	->setObject($mainMedia)
	->loadTemplate('admin/media/list');
