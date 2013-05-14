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

class Controller_Admin_Media extends Controller
{


	public function index() {
		$division = new Model_Ttdivision($this->database, $this->config);
		$division->read();
		$user = new Model_Mainuser($this->database, $this->config);
		$this->view->setObject($division);
		$this->view->loadTemplate('admin/league');
	}


	public function gallery() {
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
			if (! $player->readById(array($_GET['edit']))) {
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

	
}
	