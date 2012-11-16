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


	public function getUnset($key)
	{

		if (array_key_exists($key, $_SESSION)) {

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
