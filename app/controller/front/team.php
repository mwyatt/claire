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
			$this->view
				->setMeta(array(		
					'title' => $team->getData('name')
				))
				->setObject($team)
				->loadTemplate('team-single');
		}
		$team->read();
		$this->view
			->setMeta(array(		
				'title' => 'All registered teams'
				, 'keywords' => 'teams, team'
				, 'description' => 'All registered teams in the East Lancashire Table Tennis League'
			))
			->setObject($team)
			->loadTemplate('team');
	}

	
}
