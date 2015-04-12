<?php


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
$package = json_decode(file_get_contents(BASE_PATH . 'package' . '.json'));
if (! isset($package->site)) {
	exit('please specify a app config');
}
define('SITE', $package->site);


/**
 * handy for file includes
 */
define('SITE_PATH', APP_PATH . 'Site' . DS . ucfirst(SITE) . DS);
