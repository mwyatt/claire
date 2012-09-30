<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
  
  
// Models 
require_once('app/model/content.php');


// Sub Page
if ($config->getUrl(3)) {

	if ($file = $config->findFile('app/cc/controller/'
		. $config->getUrl(2) . '/' . $config->getUrl(3) . '.php'))
	{
		require_once($file);
		exit;
	}
}


// Invalid Url
if ($config->getUrl(3)) {
	$route->home('cc/' . $config->getUrl(2) . '/');
}


// Objects
$posts = new Content($DBH);

// Actions
$posts->selectType('post', 0);

// View: posts
require_once('app/cc/view/posts.php');
exit;