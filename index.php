<?php

/**
 * Boop!
 * 
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
 
 //require_once( dirname(__FILE__) . '/what.php' );
 
// Base Classes
// -----------------------------------------------------------------------------
require_once('credentials.php');
require_once('app/connect.php');
require_once('app/session.php');
require_once('app/class/config.php');
require_once('app/class/error.php');
require_once('app/class/route.php');
require_once('app/class/controller.php');
require_once('app/class/model.php');
require_once('app/class/view.php');
require_once('app/model/options.php');
require_once('app/model/user.php');


// Initiate Core Objects
// -----------------------------------------------------------------------------
$config = new Config();
$config
	->setUrl()
	->setUrlBase();
$controller = new Controller();
$route = new Route($config->getUrlBase(), $config->getUrl());
	

// Flush Database
// -----------------------------------------------------------------------------
if (array_key_exists('flush', $_GET)) {	
	unlink('installed.txt');
	$DBH->query("DROP DATABASE mvc_002"); 
	$DBH->query("CREATE DATABASE mvc_002");
	echo '<a href="http://localhost/mvc/">OK THANKS</a><br><br>';
	exit('database flushed');
}


// Install Database
// -----------------------------------------------------------------------------
if ($file = $config->findFile('installed.txt')) {}
else {

	// Begin Installation
	require_once('app/cc/install.php');
	exit;
}


// Master Controller
// -----------------------------------------------------------------------------
require_once('app/index.php');


// Exit.
// -----------------------------------------------------------------------------
exit;