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

class Controller_Front extends Controller
{


	public function initialise() {
		$menu = new Model_Mainmenu($this->database, $this->config);
		$menu->division();
		$this->view->setObject($menu);
	}


	public function index() {
		$press = new Model_maincontent($this->database, $this->config);
		$press->readByType('press', 3);
		// echo '<pre>';
		// print_r($press->data);
		// echo '</pre>';
		// exit;
		
		$this->view
			->setObject($press)
			->loadTemplate('home');
	}


	public function player() {
		$this->load(array('front', 'player'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


}
