<?php

/**
 * admin
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Admin_League extends Controller
{


	// public function initialise() {
	// 	if (array_key_exists('page', $_GET)) {
	// 		$controller->loadMethod($_GET['page']);
	// 	} else {
	// 		$controller->loadMethod('index');
	// 	}
	// }


	/**
	 * dashboard of admin area, displays login until logged in, then dashboard
	 */
	public function index() {
		$division = new Model_Ttdivision($this->database, $this->config);
		$division->read();
		$user = new Model_Mainuser($this->database, $this->config);
		$this->view->setObject($division);
		$this->view->loadTemplate('admin/league');
	}


	public function player() {
		$player = new Model_Ttplayer($this->database, $this->config);
		$division = new Model_Ttdivision($this->database, $this->config);
		if (array_key_exists('form_update', $_POST)) {
			$player->update();
			$this->route('current');
		}
		if (array_key_exists('form_create', $_POST)) {
			$player->create();
			$this->route('current');
		}
		if (array_key_exists('edit', $_GET)) {
			if (! $player->readById($_GET['edit'])) {
				$this->route('current_noquery');
			}
			$division->read();
			$team = new Model_Ttteam($this->database, $this->config);
			$team->readByDivision($player->get('division_id'));
			$this->view	
				->setObject($division)
				->setObject($team)
				->setObject($player)
				->loadTemplate('admin/league/player-create-update');
		}
		if (array_key_exists('delete', $_GET)) {
			$player->deleteById($_GET['delete']);
			$this->route('current_noquery');
		}
		if ($this->config->getUrl(3) == 'new') {
			$division->read();
			$this->view->setObject($division);
			$this->view->loadTemplate('admin/league/player-create-update');
		}
		$player->read();
		$this->view
			->setObject($player)
			->loadTemplate('admin/league/player');
	}


	public function team() {
		$team = new Model_Ttteam($this->database, $this->config);
		$weekday = new Model_Ttteam($this->database, $this->config);
		$division = new Model_Ttdivision($this->database, $this->config);
		$venue = new Model_Ttvenue($this->database, $this->config);
		$player = new Model_Ttplayer($this->database, $this->config);
		if (array_key_exists('form_update', $_POST)) {
			$team->update($_GET['edit']);
			$this->route('current');
		}
		if (array_key_exists('form_create', $_POST)) {
			$team->create();
			$this->route('current');
		}
		if (array_key_exists('edit', $_GET)) {
			if ($team->readById($_GET['edit'])) {
				$division->read();
				$weekday->readWeekDays();
				$venue->read();
				$player->readByTeam($_GET['edit']);
				$this->view	
					->setObject($team)
					->setObject($venue)
					->setObject($player)
					->setObject('home_nights', $weekday)
					->setObject($division)
					->loadTemplate('admin/league/team-create-update');
			}
			$this->route('current_noquery');
		}
		if (array_key_exists('delete', $_GET)) {
			$team->delete($_GET['delete']);
			$this->route('current_noquery');
		}
		if ($this->config->getUrl(3) == 'new') {
			$division->read();
			$team->readWeekDays();
			$venue->read();
			$this->view
				->setObject($venue)
				->setObject('home_nights', $team)
				->setObject($division);
			$this->view->loadTemplate('admin/league/team-create-update');
		}
		$team->read();
		$this->view
			->setObject($team)
			->loadTemplate('admin/league/team');
	}


	public function fixture() {
		$model = new Model_Ttfixture($this->database, $this->config);
		$fixture = new Model_Ttfixture($this->database, $this->config);
		$division = new Model_Ttdivision($this->database, $this->config);
		if (array_key_exists('form_fulfill', $_POST)) {
			$fixture->fulfill();
			$this->route('current');
		}
		$division->read();
		if ($this->config->getUrl(3) == 'fulfill') {
			$model->data = $model->getEncounterStructure();
			$division->read();
			$this->view
				->setObject('encounter_structure', $model)
				->setObject($division);
			$this->view->loadTemplate('admin/league/fixture-fulfill');
		}
		$fixture->read();
		$this->view
			->setObject($division)
			->setObject($fixture)
			->loadTemplate('admin/league/fixture');
	}

	
}
	