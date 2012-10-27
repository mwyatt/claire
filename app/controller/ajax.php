<?php

/**
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

if ($config->getUrl(1)) {

	$path = BASE_PATH . 'app/controller/' . $config->getUrl(0) . '/' . $config->getUrl(1) . '.php';

	if (is_file($path))
		require_once($path);
	else
		$route->home();	
		
} else {

	$route->home();

}

exit;