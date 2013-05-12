<?php

/**
 * Initiate Application
 * 
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 

define('BASE_PATH', (string) (__DIR__ . '/'));
require_once(BASE_PATH . 'app/autoloader.php');
spl_autoload_register(array('Autoloader', 'load'));
$error = new Error($debug = 'yes');
$database = new Database();
$session = new Session();
$session
	->start();
$config = new Config();
$config
	->setUrl();
$route = new Route();
$route
	->setObject($config);
$config
	->setObject($error)
	->setObject($session)
	->setObject($route);
if (array_key_exists('install', $_GET)) {
	require_once(BASE_PATH . 'install.php');
}
$controller = new Controller();
if ($controller->load(array($config->getUrl(0)), $config->getUrl(1), false, $database, $config)) {
	// admin, ajax
} else {
	$controller->load(array('front'), $config->getUrl(0), false, $database, $config);
}
exit;
