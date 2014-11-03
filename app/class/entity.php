<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Entity
{


	private $id;


	/**
	 * @return int 
	 */
	public function getId() {
	    return $this->id;
	}
	
	
	/**
	 * @param int $id 
	 */
	public function setId($id) {
	    $this->id = $id;
	    return $this;
	}


	/**
	 * takes the url object from the registry and passes back the
	 * absolute url for the website
	 * @return string 
	 */
	public function getUrlAbsolute()
	{
		$registry = OriginalAppName\Registry::getInstance();
		return $registry->get('url')->getCache('base');
	}
}
