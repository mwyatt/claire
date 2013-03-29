<?php

/**
 * Controller
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
 
class Controller
{
	public $config;

	
	public function __construct($config) {
		
		$this->config = $config;
		
	}

	/**
	 * returns an object if it has been registered
	 */	
	public function load()	{
		echo '<pre>';
		print_r($this->config->getUrl());
		echo '</pre>';
		exit;
	}
}