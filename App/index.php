<?php

namespace OriginalAppName;


use OriginalAppName;


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
$registry->set('configApp', $configApp);
$ok = new OriginalAppName\Admin\Session\User\ForgotPassword;


/**
 * find all possible routes
 * @var OriginalAppName
 */
$route = new OriginalAppName\Route;
$route->readRoutes();


/**
 * url must contain a reference to the routes
 */
$url = new OriginalAppName\Url;
$url->setRoutes($route->getRoutes());
$registry->set('url', $url);


/**
 * unit tests
 */
// $test = new OriginalAppName\Test();
// $test->mail();


/**
 * find appropriate route and load controller
 * @var route
 */
$route->init();


/**
 * cron
 * handle any post render processes
 */
// $cron = new cron($system);
// $cron->refresh(array(
// 	'cron_email_newsletter'
// ));


/**
 * it was nice seeing you
 */
exit;
