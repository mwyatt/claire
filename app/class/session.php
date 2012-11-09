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


	public function set($data)
	{

		if (is_array($data)) {

			$_SESSION[$key] = $string;

			$key = key($data);

		}

		return;

	}
	
	
}
