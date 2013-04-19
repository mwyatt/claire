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


	public function start() {
		session_start();
	}


	public function get($key, $subKey = '') {
		if (array_key_exists($key, $_SESSION)) {
			if (array_key_exists($subKey, $_SESSION[$key])) {
				$value = $_SESSION[$key][$subKey];
				return $value;
			}
			$value = $_SESSION[$key];
			return $value;
		}
		return false;
	}


	/**
	 * gets array or sub array, returns and destroys session data
	 * @param  string  $key    
	 * @param  boolean $subKey will be string when used
	 * @return anything          
	 */
	public function getUnset($key, $subKey = false) {
		if (array_key_exists($key, $_SESSION)) {
			if (! $subKey) {
				$value = $_SESSION[$key];
				unset($_SESSION[$key]);
				return $value;
			}
			if (array_key_exists($subKey, $_SESSION[$key])) {
				$value = $_SESSION[$key][$subKey];
				unset($_SESSION[$key][$subKey]);
				return $value;
			}
		}
		return false;
	}


	public function set($key, $keyTwo, $keyThree = false) {
		if ($keyThree) {
			$_SESSION[$key][$keyTwo] = $keyThree;
			return true;
		}
		if ($_SESSION[$key] = $keyTwo)
			return true;
		else
			return false;

	}


	public function setIncrement($key, $value) {

		if ($_SESSION[$key][] = $value)
			return true;
		else
			return false;

	}


	public function getPreviousUrl($current) {
		if (! array_key_exists('history', $_SESSION)) {
			$_SESSION['history'][0] = $current;
			$_SESSION['history'][1] = false;
			return;
		} else {
			if ($_SESSION['history'][0]) {
				$_SESSION['history'][1] = $_SESSION['history'][0];
			}
			$_SESSION['history'][0] = $current;
			if ($_SESSION['history'][1]) {
				return $_SESSION['history'][1];
			} else {
				return;
			}
		}
	}

	public function getData() {		
		return $this->data = $_SESSION;
	}	

}
