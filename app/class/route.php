<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Route extends Config
{

	public function __construct($urlBase, $url) {
		$this->urlBase = $urlBase;	
		$this->url = $url;
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
	
	/*
	public function _404()
	{		
		header('HTTP/1.0 404 Not Found');
		require_once('app/view/404.php');
		exit;
	}
	*/
	
}
