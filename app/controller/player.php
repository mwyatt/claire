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


	/**
	 * /player/ full player directory
	 * /player/full-name-1/ single player
	 * @param  string $action after the index?
	 */
	public function index($action) {
		$this->cache->load('player');
		$player = new Model_Ttplayer($this->database, $this->config);
		if ($action) {
			$id = end(explode('-', $this->config->getUrl(1)));
			if (! $player->readById($id)) {
				return;
			}
			$this->view
				->setObject($player)
				->loadTemplate('player-single');
		}
		$player->read();
		$this->view
			->setObject($player)
			->loadTemplate('player');
	}


	/**
	 * full table of player performance ordered by the one who is performing
	 * the best
	 */
	public function performance() {
		$this->cache->load('performance');
		$player = new Model_Ttplayer($this->database, $this->config);
		$encounterPart = new Model_ttEncounterPart($this->database, $this->config);
		$encounterPart->readPerformance();
		$this->view
			->setObject($encounterPart)
			->loadTemplate('performance');
	}

	
}
