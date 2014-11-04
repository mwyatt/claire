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


// routing fun


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
 
$request = Request::createFromGlobals();
$response = new Response();
$routes = new RouteCollection();

$routes->add('label?', new Route(
   '/ok/',
   array('controller' => function() {
        return 'what';
   })
));
$routes->add('ok?', new Route(
   '/player/{name}/',
   array('controller' => function($name) {
    echo '<pre>';
    print_r($name);
    echo '</pre>';
    exit;
    
        return new Response('Hello '.$name);
   })
));

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    $attributes = $matcher->match($request->getPathInfo());
    $controller = $attributes['controller'];
    $response = call_user_func_array($controller, $attributes);
} catch (ResourceNotFoundException $e) {
    $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
}

echo '<pre>';
print_r($response);
echo '</pre>';
exit;

return $response;




 
switch ($request->getPathInfo()) {
case '/':
    $response->setContent('This is the website home');
    break;
 
    case '/about':
        $response->setContent('This is the about page');
        break;
 
    default:
        $response->setContent('Not found !');
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
}



 
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
