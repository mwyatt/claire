<?php

/**
 * player
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Player extends Controller
{

	public function root($method) {
		$ttPlayer = new Model_ttPlayer($this->config->getObject('Database'), $this->config);
		if ($method) {
			$id = end(explode('-', $method));
			if (! $ttPlayer->readById($id)) 
				return false;
			$this->config->getObject('View')
				->setObject($ttPlayer)
				->loadTemplate('player-single');
		}
		$ttPlayer->read();
		$this->config->getObject('View')
			->setObject($ttPlayer)
			->loadTemplate('player');
	}

	public function performance() {
		echo '<pre>';
		print_r('perofmance');
		echo '</pre>';
		exit;
		
		$ttPlayer = new Model_ttPlayer($this->config->getObject('Database'), $this->config);
		$ttEncounterPart = new Model_ttEncounterPart($this->config->getObject('Database'), $this->config);
		$ttEncounterPart->readPerformance();
		$this->config->getObject('View')
			->setObject($ttEncounterPart)
			->loadTemplate('performance');
	}
	
}
