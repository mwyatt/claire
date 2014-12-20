<?php

namespace OriginalAppName;


/**
 * http://avedo.net/101/the-registry-pattern-and-php
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Registry
{


	private $registry = array();


	private static $instance = null;

	
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new Registry();
		}
		return self::$instance;
	}


	public function set($key, $value) {
		if (isset($this->registry[$key])) {
			throw new \Exception('There is already an entry for key ' . $key);
		}

		$this->registry[$key] = $value;
	}

	public function get($key) {
		if (! isset($this->registry[$key])) {
			// throw new \Exception('There is no entry for key ' . $key);
			return;
		}

		return $this->registry[$key];
	}
}
