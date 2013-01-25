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

$ttTeam = new ttTeam($database, $config);

if ($config->getUrl(1)) {
	$id = current(explode('-', $config->getUrl(1)));
	if (! $ttTeam->readById($id))
		return false;
	$view
		->setObject($ttTeam)
		->loadTemplate('team-single');
}
 
$ttTeam->read();

$view
	->setObject($ttTeam)
	->loadTemplate('team');