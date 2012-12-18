<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

// initialise 
$post = new Post($database, $config);
$post
	->setObject($session)
	->setObject($mainUser);

// next page
if ($config->getUrl(3)) {
	$view->loadTemplate('admin/posts/press/new');
}

// invalid url
if ($config->getUrl(3))
	$route->home('admin/' . $config->getUrl(1) . '/');

// view 	
$post->readByType('press');

$view
	->setObject($post)
	->loadTemplate('admin/posts/press/list');