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
$ttPlayer = new ttPlayer($database, $config);

if ($config->getUrl(1)) {
	if ($config->getUrl(1) == 'merit-table')
		$view
			->setObject($ttPlayer)
			->loadTemplate('player-single');
}
 
$ttPlayer->read();

$view
	->setObject($ttPlayer)
	->loadTemplate('division');