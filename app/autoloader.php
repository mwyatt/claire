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

	/*public static $delimit = '_';
	public static $sep = '/';
	public static $ext = '.php';
	public static $cache = '/app/cache/';
	public static $app = '/app/';
	public static $class = '/app/class/';
	public static $controller = '/app/controller/';
	public static $model = '/app/model/';
	public static $view = '/app/view/';
	public static $admin = '/app/admin/';*/
	
	public static
		$className, $classType;

	
	/**
	 * Load classes dynamically
	 * @param $className is seperated via _ for folders /moddel/class.php
	 */
	public static function load() {
		
		// build path
		$path = BASE_PATH . 'app' . '/' . AutoLoader::$classType . '/' . AutoLoader::$className . '.php';
								
		// check file exists
		if (is_file($path)) {
		
			include($path);
			return;
		}

	}	
	

	public static function loadClass($className) {
		AutoLoader::$className = strtolower($className);
		AutoLoader::$classType = 'class';
		AutoLoader::load();
	}
	
	
	public static function loadModel($className) {
		AutoLoader::$className = $className;
		AutoLoader::$classType = 'model';
		AutoLoader::load();
	}
	

	
	/*
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
*/
	
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
	
}