<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// Init
// =============================================================================

$player = new ttPlayer($database, $config);


// Form Submission
// =============================================================================

if (array_key_exists('form_player_new', $_POST)) {
	
	if ($player->create($_POST))
	
		$user->setFeedback('Player Created Successfully');
	
	else
	
		$user->setFeedback('Error Detected, Player has not been Created');
		
	$route->current();
	
}


// New
// =============================================================================

if ($config->getUrl(2) == 'new') {

	$view->loadTemplate('admin/player/new');	
	
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
		
$post = new Post($database, $config);
$post->select();

$view
	->registerObjects(array($user, $post))
	->loadTemplate('admin/posts');