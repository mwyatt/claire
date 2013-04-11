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

		if (array_key_exists('page', $_GET)) {
			$this->view->loadTemplate('admin/league/' . $_GET['page']);
		}

		$this->view->loadTemplate('admin/league');

		
	}


	public function player() {
		echo '<pre>';
		print_r('player');
		echo '</pre>';
		exit;
		
	}


	public function team() {}


	public function fixture() {}

	
}
	