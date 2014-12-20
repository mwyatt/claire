<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Entity
{


	protected $id;


	/**
	 * @return int 
	 */
	public function getId() {
	    return $this->id;
	}
	
	
	/**
	 * @todo possibly not needed because when would you use it?
	 * @param int $id 
	 */
	// public function setId($id) {
	//     $this->id = $id;
	//     return $this;
	// }


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


	public function getUrlGenerator()
	{
		$registry = \OriginalAppName\Registry::getInstance();
		return $registry->get('urlGenerator');
	}
}
