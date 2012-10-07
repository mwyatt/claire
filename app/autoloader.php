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

	public static $className;
	public static $classType;

	
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