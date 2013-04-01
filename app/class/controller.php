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
 
class Controller extends Model
{


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
			$controllerName = 'Controller' . '_' . ucfirst($this->config->getUrl(0));
			$controller = new $controllerName($this->database, $this->config);
			$view = new View($this->database, $this->config);
			$view->setObject($this->config->getObject('Session'));
			$controller->view = $view;
			$controller->loadMethod($this->config->getUrl(1));
			return true;
		}
		return false;
	}


}