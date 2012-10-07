<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
  
  
// New / Edit Post
// =============================================================================

if (array_key_exists('edit', $_GET)) {
	require_once('app/cc/controller/posts/edit.php');
	exit;
}


// Sub Page
// =============================================================================

if ($config->getUrl(3)) {

	if ($file = $config->findFile('app/cc/controller/'
		. $config->getUrl(2) . '/' . $config->getUrl(3) . '.php'))
	{
		require_once($file);
		exit;
	}
}


// Invalid Url
// =============================================================================

if ($config->getUrl(3))
	$route->home('admin/' . $config->getUrl(2) . '/');

	
// View: admin/posts.php
// =============================================================================
		
$posts = new Content($database, $config, 'post');
$posts->select();

$view
	->registerObjects(array($user, $posts))
	->loadTemplate('admin/posts');