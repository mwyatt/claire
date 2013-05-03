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

class Controller_Front_Player extends Controller
{


	/**
	 * /player/ full player directory
	 * /player/full-name-1/ single player
	 * @param  string $action after the index?
	 */
	public function index() {
		// $this->cache->load('player');
		$player = new Model_Ttplayer($this->database, $this->config);
		if ($this->config->getUrl(1)) {
			$id = end(explode('-', $this->config->getUrl(1)));
			if (! $player->readById(array($id))) {
				$this->route('base', 'player/');
			}
			$this->view
				->setMeta(array(		
					'title' => 'custom title'
					, 'keywords' => 'custom title'
					, 'description' => 'custom title'
				))
				->setObject($player)
				->loadTemplate('player-single');
		}
		$player->read();
		$this->view
			->setMeta(array(		
				'title' => 'All registered players'
				, 'keywords' => 'players, player'
				, 'description' => 'All registered players in the East Lancashire Table Tennis League'
			))
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
