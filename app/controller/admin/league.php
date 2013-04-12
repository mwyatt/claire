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


	/**
	 * dashboard of admin area, displays login until logged in, then dashboard
	 */
	public function index() {
		$ttdivision = new Model_Ttdivision($this->database, $this->config);
		$ttdivision->read();
		$user = new Model_Mainuser($this->database, $this->config);
		$user->setObject($this->config->getObject('session'));
		$this->view->setObject($ttdivision);
		$this->view->setObject($user);
		$this->view->loadTemplate('admin/league');
	}


	public function player() {
		
		// initialise 

		$ttPlayer = new ttPlayer($database, $config);
		$ttDivision = new ttDivision($database, $config);

		$ttPlayer
			->setObject($session)
			->setObject($mainUser);

		// (POST) update

		if (array_key_exists('form_player_update', $_POST)) {

			$ttPlayer->update($_POST);
				
			$route->current();
			
		}

		// (POST) new

		if (array_key_exists('form_player_new', $_POST)) {
			
			$ttPlayer->create($_POST);

			$route->homeAdmin('player/');
			
		}

		// (GET) update

		if (array_key_exists('update', $_GET)) {

			if (! $ttPlayer->readById($_GET['update']))
				$route->current();

			$ttDivision->read();
			$ttTeam = new ttTeam($database, $config);
			$ttTeam->readByDivision($ttPlayer->get('division_id'));

			$view	
				->setObject($ttDivision)
				->setObject($ttTeam)
				->setObject($ttPlayer)
				->loadTemplate('admin/league/player/update');
				
		}

		// (GET) delete

		if (array_key_exists('delete', $_GET)) {
			
			$ttPlayer->deleteById($_GET['delete']);
				
		}

		// next page

		if ($config->getUrl(3)) {

			if ($config->getUrl(3) == 'new') {

				$ttDivision->read();

				$view->setObject($ttDivision);

			}

			$view->loadTemplate('admin/league/player/new');	
			
		}

		// invalid url

		if ($config->getUrl(3))
			$route->home('admin/' . $config->getUrl(2) . '/');

		// view 	
			
		$ttPlayer->read();

		$view
			->setObject(array($mainUser, $ttPlayer))
			->loadTemplate('admin/league/player/list');
	}


	public function team() {
		// initialise 

		$ttTeam = new ttTeam($database, $config);
		$ttDivision = new ttDivision($database, $config);

		$ttTeam->setObject($mainUser);

		// (POST) update

		if (array_key_exists('form_team_update', $_POST)) {

			$ttTeam->update($_POST);
				
			$route->current();
			
		}

		// (POST) new

		if (array_key_exists('form_team_new', $_POST)) {

			$ttTeam->create($_POST);

			$route->homeAdmin('team/');
			
		}

		// (GET) update

		if (array_key_exists('update', $_GET)) {

			if (! $ttTeam->readById($_GET['update']))
				$route->current();

			$ttVenue = new ttVenue($database, $config);
			$ttVenue->read();
			$ttSecretary = new ttSecretary($database, $config);
			$ttSecretary->read();
			$ttDivision->read();

			$view
				->setObject($ttDivision)
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

		if ($config->getUrl(3)) {

			// new

			if ($config->getUrl(3) == 'new') {

				$ttVenue = new ttVenue($database, $config);
				$ttVenue->read();
				$ttDivision->read();

				$view
					->setObject($ttTeam)
					->setObject($ttDivision)
					->setObject($ttVenue);

			}

			$view->loadTemplate($config->getUrl(1) . '/' . $config->getUrl(2) . '/' . $config->getUrl(3));	
			
		}

		// invalid url

		if ($config->getUrl(3))
			$route->home('admin/' . $config->getUrl(2) . '/');

		// view 	
			
		$ttTeam->read();

		$view
			->setObject($ttTeam)
			->loadTemplate('admin/league/team/list');
	}


	public function fixture() {
		// Init
		// ============================================================================

		$ttFixture = new ttFixture($database, $config);
		$ttFixture
			->setObject($mainUser)
			->setObject($session);

		$ttDivision = new ttDivision($database, $config);

		$ttDivision->read();

		$view->setObject(array($mainUser, $ttDivision, $ttFixture, $session));

		// Form Submission
		// ============================================================================

		if (array_key_exists('form_fixture_fulfill', $_POST)) {

			$ttFixture->fulfill($_POST);
			$route->current();		
			
		}


		// Sub Page
		// ============================================================================

		if ($config->getUrl(3)) {

			$view->loadTemplate($config->getUrl(0) . '/' . $config->getUrl(1) . '/' . $config->getUrl(2) . '/' . $config->getUrl(3));

		}


		// View: admin/fixture/list.php
		// ============================================================================
				
		$ttFixture->read();

		$view
			->setObject($ttFixture)
			->loadTemplate('admin/league/fixture/list');
	}

	
}
	