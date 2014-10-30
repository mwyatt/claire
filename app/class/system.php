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
	 * spine of system, builds itself initially then can be used throughout
	 * using handy functions
	 * @var object
	 */
	public $url;


	/**
	 * holds easily accessible rows from the database table 'options'
	 * @var object
	 */
	public $config;


	/**
	 * the database instance
	 * @var object
	 */
	public $database;


	/**
	 * ability to share this system object
	 * @param object $system 
	 */
	public function __construct($system = false) {
		if (! $system) {
			return;
		}
		$this->setUrl($system->getUrl());
		$this->setConfig($system->getConfig());
		$this->setDatabase($system->getDatabase());
	}


	/**
	 * @param object $value 
	 */
	public function setUrl($value)
	{
		$this->url = $value;
	}


	/**
	 * @param object $value 
	 */
	public function getUrl()
	{
		return $this->url;
	}


	/**
	 * @param object $value 
	 */
	public function setConfig($value)
	{
		$this->config = $value;
	}


	/**
	 * @param object $value 
	 */
	public function getConfig()
	{
		return $this->config;
	}


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
	 * moves the script to another url, could be full or
	 * looking for a scheme in the url array
	 * @param  string  $scheme see class 'Config'
	 * @param  string $path   extension of the base action
	 */
	public function route($schemeOrFullPath = '', $extension = false) {		
		if ($this->url->getCache($schemeOrFullPath)) {
			$url = $this->url->getCache($schemeOrFullPath);
		} else {
			$url = $schemeOrFullPath;
		}
		header("Location: " . $url . $extension);
		exit;
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
