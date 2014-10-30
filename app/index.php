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
 * system
 */
$system = new OriginalAppName\System();


/**
 * setup database
 */
$database = new OriginalAppName\Database(include SITE_PATH . 'credentials' . EXT);


/**
 * url
 */
$url = new OriginalAppName\Url();


/**
 * absolute url
 */
define('URL_ABSOLUTE', $url->getCache('base'));


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
