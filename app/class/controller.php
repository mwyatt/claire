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
 
class Controller extends Config
{


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


	public function __construct($database, $config) {
		$this->database = $database;
		$this->config = $config;
		$this->view = new View($this->database, $this->config);
		$this->cache = new Cache(false);
		// $this->view->setObject($this->config->getObject('session'));
		if (method_exists($this, 'initialise')) {
			$this->initialise();
		}
	}


	/**
	 * loads up controller method, otherwise use default method 'index'
	 * @param  string $method 
	 * @return null         
	 */
	public function loadMethod($method) {
		$words = explode('-', $method);
		$method = '';
		foreach ($words as $word) {
			$method .= ucfirst($word);
		}
		$method = lcfirst($method);
		if (method_exists($this, $method)) {
			$this->$method();
			return;			
		} else {
			$this->index();
		}
	}


	/**
	 * attempts to load controller based on segment(s) given
	 * if file found then it is included and config is passed through
	 * @param  string $path
	 * @return null
	 */
	public function load($segments)	{
		$path = BASE_PATH . 'app/controller/';
		if (is_array($segments)) {
			foreach ($segments as $key => $segment) {
				if ($segment) {
					$path .= strtolower($segment) . '/';
				}
			}
			$path = rtrim($path, '/');
			$controllerName = 'Controller_' . ucfirst(reset($segments));
			$methodName = next($segments);
		} else {
			$path .= strtolower($segments);
			$controllerName = 'Controller_' . $segments;
			$methodName = '';
		}
		$path .= '.php';
		if (is_file($path)) {
			$controller = new $controllerName($this->database, $this->config);
			$controller->loadMethod($methodName);
			return true;
		}
		return false;
	}


	/**
	 * moves the script to another url, possibly replaces class 'Route'
	 * @param  string  $base see class 'Config'
	 * @param  string $path   extension of the base action
	 * @return null          
	 */
	public function route($base, $path = false) {		
		header("Location: " . $this->config->getUrl($base) . $path);
		exit;
	}


}