<?php

use Orno\Http\Request;
use Orno\Http\Response;


/**
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 


/**
 * boot session
 */
session_start();


/**
 * setup registry
 */
$registry = OriginalAppName\Registry::getInstance();
$registry->set('system', new OriginalAppName\System);
$registry->set('database', new OriginalAppName\Database(include SITE_PATH . 'credentials' . EXT));
$registry->set('url', new OriginalAppName\Url);


/**
 * absolute url
 */
define('URL_ABSOLUTE', $registry->get('url')->getCache('base'));


/**
 * routing with orno
 */
$router = new Orno\Route\RouteCollection;

// site specific routes
$routes = include SITE_PATH . 'route' . EXT;

// builds the routes
foreach ($routes as $route) {
	$router->addRoute(strtoupper($route[0]), $route[1], $route[2]);
}

// fire the request, collect the response
try {
	$dispatcher = $router->getDispatcher();
	$response = $dispatcher->dispatch('GET', $registry->get('url')->getPathString());
} catch (Exception $e) {
	header('HTTP/1.0 404 Not Found');
	exit('404');
}

// outputs html
$response->send();
exit;




/**
 * build options and set into config
 * @var model_options
 */
$options = new model_options($system);
$options->read();
$options->keyByProperty('name');
$system->config->setOptions($options->getData());


/**
 * error reporting
 * @var error
 */
$error = new error($system);
$error
	->setReporting(true)
	->initialise();


/**
 * store each unique url
 */
$sessionHistory = new session_history($system);
$sessionHistory->add($system->url->getCache('current'));


/**
 * unit tests
 */
$test = new test($system);
// $test->genpassword();


/**
 * find appropriate route and load controller
 * @var route
 */
$route = new route($system);
$route->readMap();
$route->load();


/**
 * cron
 * handle any post render processes
 */
$cron = new cron($system);
$cron->refresh(array(
	'cron_email_newsletter'
));


/**
 * it was nice seeing you
 */
exit;
