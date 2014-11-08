<?php


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
 * error reporting
 * @var error
 */
$error = new OriginalAppName\Error();
$error
    ->setReporting(true)
    ->initialise();


// routing fun


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
 
$request = Request::createFromGlobals();
$response = new Response();
$context = new RequestContext();
$context->fromRequest($request);
$siteRoutePath = SITE_PATH . 'route' . EXT;
if (! file_exists($siteRoutePath)) {
    exit('site \'' . SITE . '\' must have routes configured');
}
$routes = new Symfony\Component\Routing\RouteCollection();

// add routes

// admin
include APP_PATH . 'admin' . DS . 'route' . EXT;

// site
include $siteRoutePath;

// url generator
$registry->set('urlGenerator', new Symfony\Component\Routing\Generator\UrlGenerator($routes, $context));

// get match
$matcher = new UrlMatcher($routes, $context);

try {
    $attributes = $matcher->match($request->getPathInfo());

    // echo '<pre>';
    // print_r($attributes);
    // echo '</pre>';
    // exit;

    $controller = $attributes['controller'];
    unset($attributes['controller']);
    $response = call_user_func_array($controller, $attributes);
} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
} catch (Exception $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
    exit;
    
    $response = new Response('An error occurred', 500);
}

exit($response->getContent());


/**
 * build options and set into config
 * @var model_options
 */
$options = new model_options($system);
$options->read();
$options->keyByProperty('name');
$system->config->setOptions($options->getData());


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
