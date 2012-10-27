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
	 * @param array $objects 
	 */
	public function setObject($objects)
	{
	
		if (is_array($objects)) {

			foreach ($objects as $object) {
			
				$classTitle = get_class($object);
				$this->objects[$classTitle] = $object;
				
			}
			
		} else {

			$classTitle = get_class($objects);
			$this->objects[$classTitle] = $objects;

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
						
			if (array_key_exists('path', $url)) {

				$scriptName = explode('/', strtolower($_SERVER['SCRIPT_NAME']));
				array_pop($scriptName); 
				$scriptName = array_filter($scriptName); 
				$scriptName = array_values($scriptName);			
				
				$url['path'] = split('[/]', $url['path']);
				$url['path'] = array_filter($url['path']);
				$url['path'] = array_values($url['path']);
				
				foreach (array_intersect($scriptName, $url['path']) as $key => $value) {
				
					unset($url['path'][$key]);
				
				}
				
				$url['path'] = array_values($url['path']);		
				
			}		
				
			if (array_key_exists('query', $url))
				$url['query'] = split('[;&]', $url['query']);
			
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

			// removes $_GET
		
			$_SERVER['REQUEST_URI'] = strtok($_SERVER['REQUEST_URI'], '?');

			$this->url['current'] =
				'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
		}
	
		return $this;
		
	}	
	
}