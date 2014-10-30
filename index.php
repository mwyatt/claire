<?php


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
define('APP_PATH', BASE_PATH . 'app' . DS);


/**
 * composer autoloader
 */
include BASE_PATH . 'vendor' . DS . 'autoload' . EXT;


/**
 * app configuration
 */
$config = include APP_PATH . 'config' . EXT;
if (! isset($config['site'])) {
	exit('please specify a site key');
}
define('SITE', $config['site']);


/**
 * handy for file includes
 */
define('SITE_PATH', APP_PATH . 'site' . DS . SITE . DS);


/**
 * boot
 */
include APP_PATH . 'ini' . EXT;
include APP_PATH . 'index' . EXT;
