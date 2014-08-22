<?php

/**
 * base functionality for all controllers
 * 
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Route extends System
{


	/**
	 * view object which will allow the controller to move onto the view stage
	 * @var object
	 */
	public $view;


	/**
	 * plan for any incoming url, helps decide which controller to load
	 * $object->foo/bar = controller_foo_bar
	 * @var object
	 */
	public $map;


	/**
	 * the go-to controller if nothing is found
	 * @var string
	 */
	public $default = 'controller_index';


	/**
	 * storage of current class being reviewed
	 * @var string
	 */
	public $current;


	public function getDefault()
	{
		return $this->default;
	}


	public function setDefault($value)
	{
		$this->default = $value;
	}


	public function getCurrent()
	{
		return $this->current;
	}


	public function setCurrent($value)
	{
		$this->current = $value;
	}


	/**
	 * detect a route which does not exist
	 * @return boolean 
	 */
	public function isInvalid()
	{
		if ($this->url->getPathPart(0) && $this->getDefault() == $this->getCurrent()) {
			return true;
		}
	}


	/**
	 * compare the current url path to a site specific map of routes
	 * if one is found it is loaded up. once its processes are complete
	 * it is then rendered
	 */
	public function load()
	{

		// cache key variables
		$map = $this->getMap();
		$url = $this->getUrl();
		$path = $url->getPathString();

		// find a matching map property
		$this->setCurrent($this->getDefault());
		foreach ($this->getMap() as $mapPath => $class) {
			if (strpos($path, $mapPath) !== false) {
				$this->setCurrent($class);
			}
		}
		
		// trying to access a route but it does not exist
		if ($this->isInvalid()) {
			$this->route('base', 'not-found/');
		}

		// does the class exist?
		if (! class_exists($this->getCurrent())) {
			exit('class ' . $this->getCurrent() . ' does not exist in the controller folder');
		}

		// set headers
		$this->setHeaders();

		// boot class
		$current = $this->getCurrent();
		$controller = new $current($this);
		$controller->setView(new view($this));

		// initialise + run
		$controller->initialise();
		$controller->run();

		// render the data
		$controller->view->render();
	}
	

	public function setMap($value)
	{
		$this->map = $value;
	}


	public function getMap()
	{
		return $this->map;
	}


	public function readMap()
	{
		$json = new Json();
		$json->read('route');
		$this->setMap($json->getData());
	}


	public function setView($value)
	{
		$this->view = $value;
	}


	public function getView()
	{		
		return $this->view;
	}

	
	/**
	 * analysises the currently set rote and sets appropriate headers
	 */
	public function setHeaders()
	{
		$current = $this->getCurrent();
		if ($current == 'controller_notfound') {
			header('HTTP/1.0 404 Not Found');
		}
	}
}
