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

$ttPlayer = new ttPlayer($database, $config);

if ($config->getUrl(2)) {
	if ($config->getUrl(2) == 'merit') {
		$ttPlayer->readMerit($division['id']);
		$view
			->setObject($ttDivision)
			->setObject($ttPlayer)
			->loadTemplate('merit');
	}
}
 
$ttPlayer->read();

$view
	->setObject($ttPlayer)
	->loadTemplate('division');