<?php


/**
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @test is this being pulled by claireruth?
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
 * ?
 */
define('ENV', getenv('APP_ENV'));


/**
 * base filepath
 */
define('BASE_PATH', (string) (__DIR__ . DS));


/**
 * app core dir
 */
define('PATH_APP', BASE_PATH . 'app' . DS);


/**
 * class core dir
 */
define('PATH_CLASS', PATH_APP . 'class' . DS);


/**
 * model core dir
 */
define('PATH_MODEL', PATH_APP . 'model' . DS);


/**
 * site
 * get from package.json
 */
$config = json_decode(file_get_contents(BASE_PATH . 'config.json'));
define('SITE', $config->siteName);


/**
 * model core dir
 */
define('PATH_CONTROLLER', PATH_APP . 'controller' . DS . SITE . DS);



/**
 * view core dir
 */
define('PATH_VIEW', PATH_APP . 'view' . DS . SITE . DS);


/**
 * common extension for classes
 */
define('EXT', '.php');


/**
 * autoloader include and register function
 */
require PATH_CLASS . 'autoloader' . EXT;
spl_autoload_register(array('Autoloader', 'call'));


/**
 * initialise app
 */
require PATH_APP . 'initialise' . EXT;
