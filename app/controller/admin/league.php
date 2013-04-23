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
		$user->setObject($this->config->getObject('session'));
		$this->view->setObject($division);
		$this->view->setObject($user);
		$this->view->loadTemplate('admin/league');
	}


	public function player() {
		$player = new Model_Ttplayer($this->database, $this->config);
		$division = new Model_Ttdivision($this->database, $this->config);
		if (array_key_exists('form_update', $_POST)) {
			$player->update();
			$this->route('current');
		}
		if (array_key_exists('form_new', $_POST)) {
			$player->create($_POST);
			$this->route('admin', 'player/');
		}
		if (array_key_exists('edit', $_GET)) {
			if (! $player->readById($_GET['edit'])) {
				$this->route('current');
			}
			$division->read();
			$ttTeam = new Model_Ttteam($this->database, $this->config);
			$ttTeam->readByDivision($player->get('division_id'));
			$this->view	
				->setObject($division)
				->setObject($ttTeam)
				->setObject($player)
				->loadTemplate('admin/league/player-create-update');
		}
		if (array_key_exists('delete', $_GET)) {
			$player->deleteById($_GET['delete']);
		}
		if ($this->config->getUrl(3)) {
			if ($this->config->getUrl(3) == 'new') {
				$division->read();
				$this->view->setObject($division);
			}
			$this->view->loadTemplate('admin/league/player-create-update');	
		}
		if ($this->config->getUrl(3)) {
			$this->route('home', 'admin/' . $this->config->getUrl(2) . '/');
		}
		$player->read();
		$this->view
			->setObject($player)
			->loadTemplate('admin/league/player');
	}


	public function team() {
		// initialise 

		$ttTeam = new Model_Ttteam($this->database, $this->config);
		$division = new Model_Ttdivision($this->database, $this->config);

		// (POST) update

		if (array_key_exists('form_team_update', $_POST)) {

			$ttTeam->update($_POST);
				
			$this->route('current');
			
		}

		// (POST) new

		if (array_key_exists('form_team_new', $_POST)) {
			$ttTeam->create($_POST);
			$this->route('admin', 'team/');
		}

		// (GET) update

		if (array_key_exists('update', $_GET)) {

			if (! $ttTeam->readById($_GET['update']))
				$this->route('current');

			$ttVenue = new Model_Ttvenue($this->database, $this->config);
			$ttVenue->read();
			$ttSecretary = new Model_Ttsecretary($this->database, $this->config);
			$ttSecretary->read();
			$division->read();

			$this->view
				->setObject($division)
				->setObject($ttVenue)
				->setObject($ttSecretary)
				->setObject($ttTeam)
				->loadTemplate('admin/league/team/update');

		}

		// (GET) delete

		if (array_key_exists('delete', $_GET)) {
			
			$ttTeam->deleteById($_GET['delete']);
				
		}

		// next page

		if ($this->config->getUrl(3)) {

			// new

			if ($this->config->getUrl(3) == 'new') {

				$ttVenue = new Model_Ttvenue($this->database, $this->config);
				$ttVenue->read();
				$division->read();

				$this->view
					->setObject($ttTeam)
					->setObject($division)
					->setObject($ttVenue);

			}

			$this->view->loadTemplate($this->config->getUrl(1) . '/' . $this->config->getUrl(2) . '/' . $this->config->getUrl(3));	
			
		}

		// invalid url

		if ($this->config->getUrl(3))
			$this->route('home', 'admin/' . $this->config->getUrl(2) . '/');

		// view 	
			
		$ttTeam->read();

		$this->view
			->setObject($ttTeam)
			->loadTemplate('admin/league/team/list');
	}


	public function fixture() {
		// Init
		// ============================================================================

		$ttFixture = new Model_Ttfixture($this->database, $this->config);
		$division = new Model_Ttdivision($this->database, $this->config);

		$division->read();

		$this->view->setObject(array($division, $ttFixture));

		// Form Submission
		// ============================================================================

		if (array_key_exists('form_fixture_fulfill', $_POST)) {

			$ttFixture->fulfill($_POST);
			$this->route('current');		
			
		}


		// Sub Page
		// ============================================================================

		if ($this->config->getUrl(3)) {

			$this->view->loadTemplate($this->config->getUrl(0) . '/' . $this->config->getUrl(1) . '/' . $this->config->getUrl(2) . '/' . $this->config->getUrl(3));

		}


		// View: admin/fixture/list.php
		// ============================================================================
				
		$ttFixture->read();

		$this->view
			->setObject($ttFixture)
			->loadTemplate('admin/league/fixture/list');
	}

	
}
	