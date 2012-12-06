<?php

/**
 * Posts
 *
 * PHP version 5
 * 
 * @access 9
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

// next page

if ($config->getUrl(2)) {

	$path = BASE_PATH . 'app/controller/admin/posts/' . $config->getUrl(2) . '.php';

	if (is_file($path))
		require_once($path);
	
}
 
// invalid url

if ($config->getUrl(2))
	$route->home('admin/posts/');

// default page

$view->loadTemplate('admin/posts');