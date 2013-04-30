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


	public $session;


	/**
	 * cache object which will allow the controller to push out cached files
	 * speeding up some model intensive pages
	 * @var object
	 */
	public $cache;


	/**
	 * view object which will allow the controller to move onto the view stage
	 * @var object
	 */
	public $view;


	/**
	 * database
	 * @var object
	 */
	public $database;


	/**
	 * config
	 * @var object
	 */
	public $config;


	// public function __construct() {

	// }


	/**
	 * loads up controller method, otherwise use default method 'index'
	 * @param  string $method 
	 * @return null         
	 */
	protected function loadMethod($method) {
		$words = explode('-', $method);
		$method = '';
		foreach ($words as $word) {
			$method .= ucfirst($word);
		}
		$method = lcfirst($method);
		if (method_exists($this, $method)) {
			return $this->$method();
		}
		return $this->index();
	}


	/**
	 * attempts to load controller based on segment(s) given
	 * if file found then it is included and config is passed through
	 * @todo add a param for passing view object through so that global data
	 * is spared
	 * @param  string $path
	 * @return null
	 */
	public function load($names = false, $method = false, $view = false, $database = false, $config = false)	{
		if ($database && $config) {
			$this->database = $database;
			$this->config = $config;
		} else {
			return false;
		}
		$this->session = new Session();
		$this->cache = new Cache(false);
		if ($view) {
			$this->view = $view;
		} else {
			$this->view = new View($this->database, $this->config);
		}
		if (method_exists($this, 'initialise')) {
			$this->initialise();
		}
		if ($names) {
			$path = BASE_PATH . 'app/controller/';
			$controllerName = 'Controller_';
			foreach ($names as $name) {
				if ($name) {
					$path .= strtolower($name) . '/';
					$controllerName .= ucfirst($name) . '_';
				}
			}
			$controllerName = rtrim($controllerName, '_');
			$path = rtrim($path, '/') . '.php';
			if (is_file($path)) {
				$controller = new $controllerName();
				$controller->load(false, false, $this->view, $this->database, $this->config);
				$controller->loadMethod($method);
				return true;
			}
		}
		return false;
	}


	/**
	 * moves the script to another url, possibly replaces class 'Route'
	 * @param  string  $scheme see class 'Config'
	 * @param  string $path   extension of the base action
	 * @return null          
	 */
	protected function route($scheme, $path = false) {		
		header("Location: " . $this->config->getUrl($scheme) . $path);
		exit;
	}

	// public function setView($view) {		
	// 	$this->view = $view;
	// }


}
