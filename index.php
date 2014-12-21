<?php

namespace OriginalAppName;

use OriginalAppName;


/**
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 


/**
 * directory seperator
 */
define('DS', DIRECTORY_SEPARATOR);


/**
 * url seperator
 */
define('US', '/');


/**
 * class seperator
 */
define('CS', '_');


/**
 * common extension for classes
 */
define('EXT', '.php');


/**
 * possibly unused?
 */
define('ENV', getenv('APP_ENV'));


/**
 * base filepath
 */
define('BASE_PATH', (string) (__DIR__ . DS));


/**
 * handy for file includes
 */
define('APP_PATH', BASE_PATH . 'App' . DS);


/**
 * composer autoloader
 */
include BASE_PATH . 'vendor' . DS . 'autoload' . EXT;


/**
 * app configuration
 */
$config = json_decode(file_get_contents(APP_PATH . 'config' . '.json'));
if (! isset($config->site)) {
	exit('please specify a app config');
}
define('SITE', $config->site);


/**
 * get error reporting in asap
 * whether it reports errors is determined by config.json
 */
$error = new OriginalAppName\Error($config->errorReporting);


/**
 * handy for file includes
 */
define('SITE_PATH', APP_PATH . 'Site' . DS . SITE . DS);


/**
 * site configuration
 */
$config = include SITE_PATH . 'config' . EXT;
if (! isset($config['assetVersion'])) {
	exit('please specify a site config');
}
define('ASSET_VERSION', $config['assetVersion']);


/**
 * boot
 */
include APP_PATH . 'ini' . EXT;
include APP_PATH . 'index' . EXT;
