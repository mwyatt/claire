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
		$this->view->setObject($this->config->getObject('Session'));

		if (method_exists($this, 'initialise')) {
			$this->initialise();
		}
	}


	/**
	 * loads up controller method, otherwise use default method 'index'
	 * @param  string $action 
	 * @return null         
	 */
	public function loadMethod($action) {
		$words = explode('-', $action);
		$action = '';
		foreach ($words as $word) {
			$action .= ucfirst($word);
		}
		$action = lcfirst($action);
		
		if (method_exists($this, $action)) {
			$this->$action($this->config->getUrl(2));
			return;			
		} else {
			$this->index($action);
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
				$path .= $segment . '/';
			}
			$path = substr_replace($path, '', -1);
		} else {
			$path .= $segments;
		}
		$path .= '.php';
		if (is_file($path)) {
			$controllerName = 'Controller_' . ucfirst($this->config->getUrl(0));
			$controller = new $controllerName($this->database, $this->config);
			$controller->loadMethod($this->config->getUrl(1));
			return true;
		}
		return false;
	}


	/**
	 * moves the script to another url, possibly replaces class 'Route'
	 * @param  string  $action see class 'Config'
	 * @param  string $path   extension of the base action
	 * @return null          
	 */
	public function route($action, $path = false) {		
		header("Location: " . $this->config->getUrl($action) . $path);
		exit;
	}


}