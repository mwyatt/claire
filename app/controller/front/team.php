<?php

/**
 * team
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Front_Team extends Controller
{


	public function index() {
		$team = new Model_Ttteam($this->database, $this->config);
		if ($this->config->getUrl(1)) {
			$id = $this->getId($this->config->getUrl(1));
			if (! $team->readById(array($id))) {
				$this->route('base', 'team/');
			}
			$player = new Model_Ttplayer($this->database, $this->config);
			$player->readByTeam($id);
			$this->view
				->setMeta(array(		
					'title' => 'Team ' . $team->getData('name')
				))
				->setObject($team)
				->setObject($player)
				->loadTemplate('team-single');
		}
		$team->read();
		$this->view
			->setMeta(array(		
				'title' => 'Teams'
			))
			->setObject($team)
			->loadTemplate('team');
	}

	
}
