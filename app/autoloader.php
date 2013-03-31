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


	/**
	 * Load classes dynamically
	 * @param  string $title attempted class to load
	 * @return null            
	 */
	public static function load($title) {

		$title = strtolower($title);
		$path = BASE_PATH . 'app' . '/' . 'class' . '/' . $title . '.php';
						
		if (is_file($path)) {
			include($path);
			return;
		}

		if ($explodedPath = explode('_', $title)) {
			if (current($explodedPath) == 'controller') {
				$path = BASE_PATH . 'app/' . current($explodedPath) . '/' . next($explodedPath) . '.php';
				if (is_file($path)) {
					include($path);
					return;
				}
			}
			if (current($explodedPath) == 'model') {
				$path = BASE_PATH . 'app/' . current($explodedPath) . '/' . next($explodedPath) . '.php';
				if (is_file($path)) {
					include($path);
					return;
				}
			}
		}

		echo '<h2>' . 'Class or Model does not exist' . '<h2>';
		echo '<pre>';
		echo $title . '<br>';
		print_r($explodedPath);
		echo '</pre>';

		exit;
		
	}
	
}