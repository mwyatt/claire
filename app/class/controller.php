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

	public function loadMethod($method) {
		if (method_exists($this, $method)) {
			$this->$method();
			return;			
		} else {
			$this->root($method);
		}
	}

	/**
	 * attempts to load controller based on segment(s) given
	 * if file found then it is included and config is passed through
	 * @param  string $path
	 * @return null
	 */
	public function load()	{

		$path = BASE_PATH . 'app/controller/' . $this->config->getUrl(0) . '.php';

		if (is_file($path)) {
			$controllerName = 'Controller' . '_' . ucfirst($this->config->getUrl(0));
			$controller = new $controllerName($this->config);
			$controller->loadMethod($this->config->getUrl(1));
			return true;
		}

		return false;
	}
}