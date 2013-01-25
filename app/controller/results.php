<?php

/**
 * League
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

$ttDivision = new ttDivision($database, $config);
$ttDivision->read();

if ($config->getUrl(1)) {
	foreach ($ttDivision->getData() as $division) {
		if ($config->getUrl(1) == strtolower($division['name']))
			$view->loadTemplate('division');
	}
}
$route->home();