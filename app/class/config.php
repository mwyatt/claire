<?php

/**
 * Core Configuration Options
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Config
{

	public $url;
	public $urlBase;
	
	
	public function __construct() {
		$this->setUrl();
		$this->setUrlBase();
	}

	
	/**
	 * Sets up the url property
	 *
	 * @todo when ? is used inside url it breaks!	 
	 * @return object $this
	 */	
	public function setUrl()
	{
	
		// Removes GET Variable(s)
		$url = strtok($_SERVER['REQUEST_URI'], '?'); 
		
		// Split via '/'
		$url = explode('/', strtolower($url));
		
		// Split script via '/'
		$script = explode('/', strtolower($_SERVER['SCRIPT_NAME']));
		
		// strip all preceding '/'
		for($i = 0; $i < count($script); $i++) {
			if ($url[$i] == $script[$i]) {
				unset($url[$i]);
			}
		}
		// Remove empty '/'
		$url = array_filter($url);
		
		// Reset keys
		$url = array_values($url);
		
		// Set property url
		$this->url = $url;
		
	}
	
	
	/**
	 * Sets up the urlBase property
	 *
	 * @return object $this
	 */		 
	public function setUrlBase()
	{
	
		// Split script via '/'
		$script = explode('/', strtolower($_SERVER['SCRIPT_NAME']));
		
		// Pop element off end of array
		array_pop($script); 
		
		// Remove empty '/'
		$script	= array_filter($script); 
		
		// Reset keys
		$script = array_values($script);
		
		$base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';
		for($i = 0; $i < count($script); $i++) {
			$base_url .= $script[$i].'/';
		}
		
		// Set property urlBase
		$this->urlBase = $base_url;
		
	}	
	
	
	/**
	 * Get urlBase value
	 *
	 * @return string|false The value or false if it does not exist
	 */		
	public function getUrlBase()
	{	
		if ($this->urlBase) {
			return $this->urlBase;
		} else {
			return false;	
		}
	}
	
	
	/**
	 * Get url array value
	 *
	 * @param integer $key The array key to return
	 * @return string|array The array value or array if it does not exist
	 */		
	public function getUrl($key = false)
	{	
		if ($key) {
		
			// Reduce integer $key by 1
			$key--;	

			// Find array key
			if (array_key_exists($key, $this->url)) {
				return $this->url[$key];
			} else {
				return false;
			}	
		} else {
			return $this->url;	
		}
	}
	
	
	public function home($ext = false)
	{		
		header("Location: " . $this->getUrlBase() . $ext);
		exit;
	}
	
	public function homeAdmin($ext = false)
	{		
		header("Location: " . $this->getUrlBase() . "admin/" . $ext);
		exit;
	}	
	
	
}