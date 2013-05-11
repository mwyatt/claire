<?php

/**
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Front_Minutes extends Controller
{


	public function index() {
		$minutes = new Model_Maincontent($this->database, $this->config);
		$minutes->readByType('minutes');
		$this->view
			->setMeta(array(		
				'title' => 'All minutes'
				, 'keywords' => 'minutes, reports'
				, 'description' => 'All minutes currently published'
			))
			->setObject($minutes)
			->loadTemplate('minutes');
	}

	
}
