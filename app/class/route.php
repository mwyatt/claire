<?php

namespace OriginalAppName;

use OriginalAppName\Registry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Generator\UrlGenerator;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Route extends \OriginalAppName\System
{


	public function __construct()
	{
	
		// resource
		$registry = Registry::getInstance();
		$request = Request::createFromGlobals();
		$context = new RequestContext();
		$context->fromRequest($request);
		$siteRoutePath = SITE_PATH . 'route' . EXT;
		if (! file_exists($siteRoutePath)) {
		    exit('site \'' . SITE . '\' must have routes configured');
		}
		$routes = new RouteCollection();

		// admin
		include APP_PATH . 'admin' . DS . 'route' . EXT;

		// site
		include $siteRoutePath;

		// url generator register
		$registry->set('urlGenerator', new UrlGenerator($routes, $context));

		// get match
		$matcher = new UrlMatcher($routes, $context);

		// try to catch any exceptions in the controllers
		try {
		    $attributes = $matcher->match($request->getPathInfo());
		    $controller = $attributes['controller'];
		    $response = new $controller($attributes);
		} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
		    $controller = new OriginalAppName\Controller();
		    $response = $controller::notFound();
		} catch (Exception $e) {
		    $response = new Response('An internal server error occurred.', HTTP_INTERNAL_SERVER_ERROR);
		}

		// the response, the only echo
		echo $response->getContent();	
	}
}
