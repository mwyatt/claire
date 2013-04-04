<?php

/**
 * Session
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Session
{


	public function __construct()
	{

		session_start();

	}


	public function get($key)
	{

		if (array_key_exists($key, $_SESSION))
			return $_SESSION[$key];
		else
			return false;

	}


	/**
	 * gets array or sub array, returns and destroys session data
	 * @param  string  $key    
	 * @param  boolean $subKey will be string when used
	 * @return anything          
	 */
	public function getUnset($key, $subKey = false)
	{
		if (array_key_exists($key, $_SESSION)) {
			if (array_key_exists($subKey, $_SESSION[$key])) {
				$value = $_SESSION[$key][$subKey];
				unset($_SESSION[$key][$subKey]);
				return $value;
			}
			$value = $_SESSION[$key];
			unset($_SESSION[$key]);
			return $value;
		}
		return false;
	}


	public function set($key, $value)
	{

		if ($_SESSION[$key] = $value)
			return true;
		else
			return false;

	}


	public function setIncrement($key, $value)
	{

		if ($_SESSION[$key][] = $value)
			return true;
		else
			return false;

	}

}
