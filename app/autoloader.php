<?php

/**
 * AutoLoader
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */


class AutoLoader {


	public static $delimit = '_';
	public static $sep = '/';
	public static $ext = '.php';
	public static $class = '/app/class/';
	public static $controller = '/app/controller/';
	public static $model = '/app/model/';
	public static $view = '/app/view/';
	public static $admin = '/app/admin/';

	
	/**
	 * Loads classes dynamically
	 * @param $class is used to require the correct file
	 */
	public static function loadClass($class) {
		
		// construct require path
		$path = BASE_PATH
			. self::$class
			. str_replace(self::$delimit, self::$sep, $class);
			
		// convert path to lowercase and append ext	
		$path = strtolower($path) . self::$ext;
		
		// check file exists
		if (is_file($path)) {
			include($path);
			return;
		}

	}
	
	
	public static function loadController($controller) {
	
		// construct require path
		$path = BASE_PATH
			. self::$controller
			. str_replace(self::$delimit, self::$sep, $controller);
			
		// convert path to lowercase and append ext	
		$path = strtolower($path) . self::$ext;
		
		// check file exists
		if (is_file($path)) {
			include($path);
			return;
		}	
	
	}
	
	
	public static function loadModel($model) {
	
		// construct require path
		$path = BASE_PATH
			. self::$model
			. str_replace(self::$delimit, self::$sep, $model);
			
		// convert path to lowercase and append ext	
		$path = strtolower($path) . self::$ext;
		
		// check file exists
		if (is_file($path)) {
			include($path);
			return;
		}		
	
	}
	
	
	public static function loadError($class) {
		return;
	}

	
	/**
	 * Search for Controllers / Files
	 *
	 * @param string $path The file path to find
	 * @return true|false The file exists else false
	 */	
	public function file($path)
	{		
		$path = BASE_PATH . self::$sep . strtolower($path) . self::$ext;
		
		if (is_file($path))
			return $path;
	}	

	
	public function controller($path)
	{		
		$path = BASE_PATH . self::$controller .  strtolower($path) . self::$ext;
		
		if (is_file($path))
			return $path;
	}	

	
	public function view($path)
	{		
		$path = BASE_PATH . self::$view .  strtolower($path) . self::$ext;
		
		if (is_file($path))
			return $path;
	}			
	
}