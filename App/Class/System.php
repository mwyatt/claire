<?php

namespace OriginalAppName;


/**
 * boilerplate for all objects in the app. responsible for how each object
 * should be implemented
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class System
{


	/**
	 * the database instance
	 * @var object
	 */
	public $database;


	/**
	 * @param object $value 
	 */
	public function setDatabase($value)
	{
		$this->database = $value;
	}


	/**
	 * @param object $value 
	 */
	public function getDatabase()
	{
		return $this->database;
	}


	/**
	 * debug mode is set
	 * @return boolean true if debug equals this class name
	 */
	public function isDebug($theObject)
	{
		if (array_key_exists('debug', $_REQUEST) && strtolower($_REQUEST['debug']) == strtolower(get_class($theObject))) {
			return true;
		}
	}
}
