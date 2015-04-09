<?php

namespace OriginalAppName;

use OriginalAppName\Registry;
use OriginalAppName\Controller;
use OriginalAppName\Session;
use OriginalAppName\Response;
use Pux;
use Pux\Executor;
use \Exception;


/**
 * 200 - OK - Returns data or status string
 * 400 - Bad request - Server didn't recognise the request
 * 401 - Not authorised - API token missing or did not authenticate
 * 500 - Server Error - Message attached will provide details
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Route extends \OriginalAppName\System
{


	public $response;


	public $routes;


	/**
	 * @return object 
	 */
	public function getResponse() {
	    return $this->response;
	}
	
	
	/**
	 * @param object $response 
	 */
	public function setResponse($response) {
	    $this->response = $response;
	    return $this;
	}


	/**
	 * @todo split off into readable class
	 */
	public function init()
	{
	
		// resource
		$registry = Registry::getInstance();
		$mux = new Pux\Mux;
		$url = $registry->get('url');
		$controller = new Controller;

		// build route tree
		$routes = $this->getRoutes();

		// store routes in mux
		foreach ($routes as $route) {
			$mux->$route['mux/type']($route['mux/path'], $route['mux/controller/method'], $route['mux/options']);
		}

		// get match
		// needs / prepending for mux
		$route = $mux->dispatch(US . $url->getPathString());

		// if route not ok will be caught
		try {

			// attempt execution of route
		    $response = Executor::execute($route);
		} catch (Exception $exception) {

			// 404
		    $response = $controller->notFound();
		}

		// headers
		// code is returned in response object
		$this->setResponse($response);
		$this->setHeaders();

		// the response, the only echo :(
		$response = $this->getResponse();

		// output
		echo $response->getContent();
	}


	/**
	 * just response code for now
	 */
	public function setHeaders()
	{
		$response = $this->getResponse();
		http_response_code($response->getStatusCode());
	}


	/**
	 * collect all routes and return for storage
	 * @return array route definitions
	 */
	public function readRoutes()
	{

		$registry = Registry::getInstance();
		$url = $registry->get('url');

		// store all routes here
		$routes = [];

		// admin first because of global ovverides
		// admin routes only if there is admin in the url
		if (in_array('admin', $url->getPath())) {
			include APP_PATH . 'Admin' . DS . 'route' . EXT;
		}

		// global
		include APP_PATH . 'route' . EXT;

		// site specific
		$siteRoutePath = SITE_PATH . 'route' . EXT;
		if (! file_exists($siteRoutePath)) {
		    exit('site \'' . SITE . '\' must have routes configured');
		}
		include $siteRoutePath;

		// return all routes
		// store also
		return $this->setRoutes($routes);
	}

	
	/**
	 * @return array 
	 */
	public function getRoutes() {
	    return $this->routes;
	}
	
	
	/**
	 * @param array $routes 
	 */
	public function setRoutes($routes) {
	    $this->routes = $routes;
	    return $this;
	}
}
