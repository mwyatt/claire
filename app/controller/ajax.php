<?php

/**
 * ajax
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Ajax extends Controller
{

	
	public function index() {
		$this->config->getObject('Route')->home();
	}

	
	public function division() {}

	
	public function fixture() {
		if (array_key_exists('team_id', $_GET)) {
			$player = new Model_Ttplayer($this->database, $this->config);
			$player->readByTeam($_GET['team_id']);
			$this->out($player->getData());
		}
	}

	
	public function team() {
		if (array_key_exists('division_id', $_GET)) {
			$team = new Model_Ttteam($this->database, $this->config);
			$team->readByDivision($_GET['division_id']);
			$this->out($team->getData());
		}
	}

	
	public function search() {
		if (array_key_exists('query', $_GET)) {
			$search = new Model_Search($this->database, $this->config);
			$search->read($_GET['query']);
			$this->out($search->getData());
		}
	}

	
	public function player() {
		if (array_key_exists('team_id', $_GET)) {
			$player = new Model_Ttplayer($this->database, $this->config);
			$player->readByTeam($_GET['team_id']);
			$this->out($search->getData());
		}
		$ttPlayer = new Model_Ttplayer($this->database, $this->config);
		$ttPlayer->read();
		$this->out($ttPlayer->getData());
	}

	
	public function mainContent() {
		if (array_key_exists('type', $_GET)) {
			$post = new Model_Maincontent($this->database, $this->config);
			$post->readByType($_GET['type'], $_GET['limit']);
			$this->out($post->getData());
		}
	}

	
	public function encounterPart() {
		if (array_key_exists('method', $_GET) && array_key_exists('player_id', $_GET)) {
			$encounter = new Model_Ttencounterpart($this->database, $this->config);
			if ($_GET['method'] == 'group') {
				$encounter->readChange($_GET['player_id']);
			}
			if ($_GET['method'] == 'row') {
				$encounter->read($_GET['player_id']);
			}
		}
	}


	/**
	 * outputs the requested data as json code
	 * @param  array $data 
	 * @return null       echos out the json data
	 */
	public function out($data) {
		if (! empty($data)) {
			echo json_encode($data);
		}
		exit;
	}


}
