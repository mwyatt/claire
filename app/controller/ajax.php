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
			if (array_key_exists('limit', $_GET)) {
				$search->read($_GET['query'], $_GET['limit']);
			} else {
				$search->read($_GET['query']);
			}
			$this->out($search->getData());
		}
	}

	
	public function player() {
		if (array_key_exists('team_id', $_GET)) {
			$player = new Model_Ttplayer($this->database, $this->config);
			$player->readByTeam($_GET['team_id']);
			$this->out($player->getData());
		}
		if (array_key_exists('id', $_GET)) {
			$player = new Model_Ttplayer($this->database, $this->config);
			if ($player->readById(array($_GET['id']))) {
				$this->out($player->getData());
			}
		}
		$ttPlayer = new Model_Ttplayer($this->database, $this->config);
		$ttPlayer->read();
		$this->out($ttPlayer->getData());
	}

	
	public function mainContent() {
		$mainContent = new Model_Maincontent($this->database, $this->config);
		if (array_key_exists('type', $_GET)) {
			$mainContent->read($_GET['type'], (array_key_exists('limit', $_GET) ? $_GET['limit'] : ''));
			$this->out($mainContent->getData());
		}
		if (array_key_exists('media', $_GET)) {
			$mainContent->readMedia($_GET['media']);
			$this->out($mainContent->getData());
		}
	}

	
	public function ttEncounterPart() {
		$encounter = new Model_Ttencounter_Part($this->database, $this->config);
		if (method_exists($encounter, $_GET['method'])) {
			$encounter->$_GET['method']($_GET['player_id']);
		}
		$this->out($encounter->getData());
	}

	public function ttEncounterResult() {
		$ttEncounterResult = new Model_Ttencounter_result($this->database, $this->config);
		if (array_key_exists('player_id', $_GET)) {
			if (array_key_exists('limit', $_GET)) {
				$ttEncounterResult->readByPlayerId($_GET['player_id'], $_GET['limit']);
			} else {
				$ttEncounterResult->readByPlayerId($_GET['player_id']);
			}
		}
		$this->out($ttEncounterResult->getData());
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
