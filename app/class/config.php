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
	private $_urlIterator = -1;
	public $options;
	
	
	/**
	 * Get options array value
	 *
	 * @param string $key The array key to return
	 * @return string|false The array value or false if it does not exist
	 */	
	public function getOption($key)
	{
		if (array_key_exists($key, $this->options)) {
			return $this->options[$key];
		} else {
			return false;
		}
	}

	
	/**
	 * Writes new key for options
	 *
	 * @param string $key The array key to set
	 * @param string $value The array value to set
	 * @return true|false If the array key and value is successfully set
	 */	
	public function setOption($key, $value)
	{
		if ($this->options[$key] = $value) {
			return true;
		} else {
			return false;
		}
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
		
		return $this;
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
		
		return $this;
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
	
	/**
	 * Get next url value based on property $_urlIterator
	 *
	 * @todo make it so that it returns each segments then false once cyle is complete	 
	 * @return string|false The array value or false if it does not exist
	 */		
	public function getNextUrl()
	{
	
		// Increments url pointer by 1
		$this->_urlIterator++;
		
		/*
		if ($this->_urlIterator < 1) {
			$this->_urlIterator = 0;
		} else {
			$this->_urlIterator++;
		}*/
		
		// Find array key
		if (array_key_exists($this->_urlIterator, $this->url)) {
			return $this->url[$this->_urlIterator];
		} else {
			$this->_urlIterator = -1;
			return false;
		}
	}
	
	
	/**
	 * Find File
	 *
	 * @param string $value The file path to find
	 * @return true|false The file exists else false
	 */	
	public function findFile($value)
	{		
		return file_exists($value) ? $value : false;
	}	
	
}