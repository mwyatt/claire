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

	public $url;
	public $urlBase;

	
	public function __construct() {
	
		$this
			->setUrl()
			->setUrlBase();
			
	}

	
	// Set
	// =========================================================================
	
	/**
	 * sets url array
	 * scheme, host, path, query
	 * returns $this
	 */	
	public function setUrl()
	{
	
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
		
		return $this;
		
	}
	
	
	/**
	 * sets clean, base url
	 * returns $this
	 */	
	public function setUrlBase()
	{
	
echo '<pre>';
print_r ($_SERVER	);
echo '</pre>';
exit;

	
		if ($this->getUrl()) {
/*
			if (array_key_exists($key = 'path', $this->url)) {
			
				first($this->url[$key]) = split('[/]', $this->url[$key]);
				$this->url[$key] = array_filter($this->url[$key]);
				$this->url[$key] = array_values($this->url[$key]);
				
			}	
		
	*/	
		
			$url = explode('/', strtolower($_SERVER['SCRIPT_NAME']));
			array_pop($url); 
			$url = array_filter($url); 
			$url = array_values($url);
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/';
			for($i = 0; $i < count($url); $i++) {
				$url .= $url[$i].'/';
			}

			$this->urlBase = $url;
		
		}

	}	
	
	
	// Get
	// =========================================================================
	
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