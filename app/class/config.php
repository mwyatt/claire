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
	public $urlBase;

	
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
	public function setObjects($objects = array())
	{
	
		foreach ($objects as $object) :
		
			$classTitle = strtolower(get_class($object));
			
			$this->objects[$classTitle] = $object;
			
		endforeach;
	
		return $this;
			
	}
	
	
	/**
	 * returns url array key
	 */		
	public function getUrl($key = false)
	{	
	
		if ($key) {
		
			if (array_key_exists($key, $this->url))
				return $this->url[$key];
			else
				return false;
				
		} else {
		
			return $this->url;
			
		}
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
			
		}
	
		return $this;
		
	}
	
	
	/**
	 * sets clean, base url
	 * returns $this
	 */	
	public function setUrlBase()
	{
	
		if ($this->getUrl()) {
		
			$this->urlBase = $this->getUrl('scheme') . '://' . $this->getUrl('host') . '/';
		
		}

	}	
	

	/**
	 * Get urlBase value
	 *
	 * @return string|false The value or false if it does not exist
	 */		
	public function getUrlBase()
	{	
		
		return $this->urlBase;
		
	}

	
	
}


// current url	
// 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']