<?php

namespace OriginalAppName;

use OriginalAppName\Registry;
use OriginalAppName\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Route extends \OriginalAppName\System
{


	public $response;


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
	public function __construct()
	{
	
		// resource
		$registry = Registry::getInstance();
		$request = Request::createFromGlobals();
		$context = new RequestContext();
		$context->fromRequest($request);

		// build route tree
		$routes = $this->getRoutes();

		// url generator register
		$registry->set('urlGenerator', new UrlGenerator($routes, $context));

		// get match
		$matcher = new UrlMatcher($routes, $context);

		// will always be overridden below
	    $this->setResponse(new Response);

		// any problems in the controllers will be caught here to throw
		// an internal server error
		// not found controllers throw 404
		try {

			// builds controller and sends to method
		    $attributes = $matcher->match($request->getPathInfo());
		    $controller = $attributes['controller'];
		    $controller = new $controller($attributes);
		    $this->setResponse($controller->$attributes['_route']($attributes));
		} catch (ResourceNotFoundException $e) {
		    $controller = new Controller();
		    $this->setResponse($controller->notFound([]));
		} catch (Exception $e) {
		    $this->setResponse(new Response('An internal server error occurred.', HTTP_INTERNAL_SERVER_ERROR));
		}

		// headers
		$this->setHeaders();

		// the response, the only echo :(
		$response = $this->getResponse();
		echo $response->getContent();
	}


	public function setHeaders()
	{
		$response = $this->getResponse();
		http_response_code($response->getStatusCode());
	}


	public function getRoutes()
	{

		// store routes in object
		$routes = new RouteCollection();

		// admin
		include APP_PATH . 'Admin' . DS . 'route' . EXT;

		// get site specific routes
		$siteRoutePath = SITE_PATH . 'route' . EXT;
		if (! file_exists($siteRoutePath)) {
		    exit('site \'' . SITE . '\' must have routes configured');
		}
		include $siteRoutePath;

		// global
		include APP_PATH . 'route' . EXT;

		// return all routes
		return $routes;
	}
}
