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
$registry->set('url', new OriginalAppName\Url);


/**
 * error reporting
 * @var error
 */
$error = new OriginalAppName\Error();
$error
    ->setReporting(true)
    ->initialise();


/**
 * store each unique url
 */
$sessionUrlHistory = new OriginalAppName\Session\UrlHistory;
$sessionUrlHistory->append($registry->get('url')->getCache('current'));


/**
 * unit tests
 */
// $test = new OriginalAppName\Test($system);
// $test->genpassword();


/**
 * find appropriate route and load controller
 * @var route
 */
$route = new OriginalAppName\Route();


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
