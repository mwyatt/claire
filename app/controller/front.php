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
		$this->view->loadTemplate('home');
	}


	public function player() {
		$this->load(array('front', 'player'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


}
