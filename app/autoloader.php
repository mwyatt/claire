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
	 * @param  string $className attempted class to load
	 * @return null            
	 */
	public static function load($className) {

		$className = strtolower($className);

		$pathClass = BASE_PATH . 'app' . '/' . 'class' . '/' . $className . '.php';
						
		$pathModel = BASE_PATH . 'app' . '/' . 'model' . '/' . $className . '.php';

		if (is_file($pathClass)) {

			// echo 'now loading: ' . $pathClass . '<br>';
			include($pathClass);
			return;

		} elseif (is_file($pathModel)) {

			// echo 'now loading: ' . $pathModel . '<br>';
			include($pathModel);
			return;

		} else {

			echo '<h2>' . 'Class or Model does not exist' . '<h2>';

			echo $pathClass . '<br>';
			echo $pathModel . '<br>';

		}

	}
	
}