<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Route extends Config
{	
	
	public function home($path = false)
	{		
		header("Location: " . $this->getUrlBase() . $path);
		exit;
	}
	
	public function homeAdmin($path = false)
	{		
		header("Location: " . $this->getUrlBase() . "admin/" . $path);
		exit;
	}
	
	
	public function home($path = false)
	{		
		header("Location: " . $this->getUrlBase() . $path);
		exit;
	}
	
	
	public function homeAdmin($path = false)
	{		
		header("Location: " . $this->getUrlBase() . "admin/" . $path);
		exit;
	}		
	
}
