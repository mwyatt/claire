<?php

/**
 * Config
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


	public $objects;
	
	public $url;

	
	/**
	 * returns an object if it has been registered
	 */	
	public function getObject($objectTitle)
	{
	
		if (array_key_exists($objectTitle, $this->objects))
		
			return $this->objects[$objectTitle];
			
		else
		
			return false;
	
	}
	
	
	/**
	 * intention is to build the object with submitted objects
	 * takes the __CLASS__ name of objects and sets them within array
	 */	
	public function setObject($objects = array())
	{
	
		foreach ($objects as $object) {
		
			$classTitle = strtolower(get_class($object));
			
			$this->objects[$classTitle] = $object;
			
		}
	
		return $this;
			
	}
	
	
	/**
	 * returns url key or path segment
	 */		
	public function getUrl($key = false)
	{	
	
		if (gettype($key) == 'integer') {
		
			if (array_key_exists('path', $this->url)) {
			
				if (array_key_exists($key, $this->url['path'])) {
				
					return $this->url['path'][$key];
				
				}
			
			}
			
			return false;
				
		}
	
		if (gettype($key) == 'string') {
		
			if (array_key_exists($key, $this->url))
			
				return $this->url[$key];
				
			return false;				
		
		}		
		
		return $this->url;
			
	}
	
	
	/**
	 * sets url array
	 * scheme, host, path, query
	 * use scheme + host for urlBase
	 * use scheme + host + path implode for urlCurrent
	 * returns $this
	 */	
	public function setUrl()
	{
	
		if ($_SERVER) {

			// Array
			
			$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			$url = parse_url($url);
			
			if (array_key_exists($key = 'path', $url)) {
			
				$url[$key] = split('[/]', $url[$key]);
				$url[$key] = array_filter($url[$key]);
				$url[$key] = array_values($url[$key]);
				
			}		
				
			if (array_key_exists($key = 'query', $url))
				$url[$key] = split('[;&]', $url[$key]);
			
			$this->url = $url;
			
			// Base
			
			$scriptName = explode('/', strtolower($_SERVER['SCRIPT_NAME']));
			array_pop($scriptName); 
			$scriptName = array_filter($scriptName); 
			$scriptName = array_values($scriptName);

			$url = 
				$this->getUrl('scheme') . '://' . $this->getUrl('host') . '/';
			
			foreach ($scriptName as $section) {
			
				$url .= $section . '/';
			
			}

			$this->url['base'] = $url;
			
			// Current
			
			$this->url['current'] =
				'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
		}
	
		return $this;
		
	}	
	
}