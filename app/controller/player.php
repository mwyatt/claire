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

if ($config->getUrl(1)) {
	$id = end(explode('-', $config->getUrl(1)));
	if (! $ttPlayer->readById($id))
		return false;
	$view
		->setObject($ttPlayer)
		->loadTemplate('player-single');
}
 
$ttPlayer->read();

$view
	->setObject($ttPlayer)
	->loadTemplate('player');