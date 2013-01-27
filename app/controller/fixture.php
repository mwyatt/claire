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

$ttFixture = new ttFixture($database, $config);

if ($config->getUrl(1)) {
	$id = end(explode('-', $config->getUrl(1)));
	if (! $ttFixture->readSingleResult($id))
		return false;
	$view
		->setObject($ttFixture)
		->loadTemplate('fixture-single');
}
 
$route->home();