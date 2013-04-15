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
		
$error = new Error('no');
$database = new Database();
$session = new Session();
$session->start();

$config = new Config();
$config
	->setUrl();

// depreciated object (now resides within controllers)
$route = new Route();
$route
	->setObject($config);

$config
	->setObject(array(
		$error
		, $session
		, $route
	));

if (array_key_exists('install', $_GET)) {
	require_once(BASE_PATH . 'install.php');
}

$controller = new Controller($database, $config);

if ($config->getUrl(0) == 'admin') {
	$controller->load($config->getUrl(0));
} elseif ($config->getUrl(0)) {
	$controller->load(array($config->getUrl(0), $config->getUrl(1)));
}

$view = new View($database, $config);
$cache = new Cache(false);
$cache->load('home');
$view->loadTemplate('home');

exit;
