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

	public function index($action) {
		$ttPlayer = new Model_Ttplayer($this->database, $this->config);
		if ($action) {
			$id = end(explode('-', $action));
			if (! $ttPlayer->readById($id)) 
				return false;
			$this->view
				->setObject($ttPlayer)
				->loadTemplate('player-single');
		}
		$ttPlayer->read();
		$this->view
			->setObject($ttPlayer)
			->loadTemplate('player');
	}

	public function performance() {
		echo '<pre>';
		print_r('perofmance');
		echo '</pre>';
		exit;
		
		$ttPlayer = new Model_Ttplayer($this->database, $this->config);
		$ttEncounterPart = new Model_ttEncounterPart($this->database, $this->config);
		$ttEncounterPart->readPerformance();
		$this->view
			->setObject($ttEncounterPart)
			->loadTemplate('performance');
	}
	
}
