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
$ttTeam = new ttTeam($database, $config);
$ttFixture = new ttFixture($database, $config);
$ttEncounterPart = new ttEncounterPart($database, $config);
$ttDivision->setData($division);

$view
	->setObject($ttDivision);

if ($config->getUrl(2)) {
	if ($config->getUrl(2) == 'merit') {
		$ttPlayer->readMerit($ttDivision->get('id'));
		$view
			->setObject($ttPlayer)
			->loadTemplate('merit');
	}
	if ($config->getUrl(2) == 'league') {
		$ttTeam->readLeague($ttDivision->get('id'));
		$view
			->setObject($ttTeam)
			->loadTemplate('league');
	}
	if ($config->getUrl(2) == 'fixture') {
		$ttFixture->readResult($ttDivision->get('id'));
		$view
			->setObject($ttFixture)
			->loadTemplate('fixture');
	}
}
 
$ttPlayer->read();

$view
	->setObject($ttPlayer)
	->loadTemplate('division');