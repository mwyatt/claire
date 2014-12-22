<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Menu extends \OriginalAppName\Entity
{


	/**
	 * INT(11) NOT NULL DEFAULT '0'
	 * id of the parent menu item
	 * @var int
	 */
	private $idParent;


	/**
	 * VARCHAR(128) NOT NULL DEFAULT
	 * name of menu item
	 * @var string
	 */
	private $name;


	/**
	 * VARCHAR(255) NOT NULL DEFAULT
	 * url append to abs url
	 * @var string
	 */
	private $url;


	/**
	 * VARCHAR(10) NOT NULL DEFAULT
	 * group key to tie different menus together
	 * @var string
	 */
	private $keyGroup;


	/**
	 * @return string 
	 */
	public function getKeyGroup() {
	    return $this->keyGroup;
	}
	
	
	/**
	 * @param string $keyGroup 
	 */
	public function setKeyGroup($keyGroup) {
	    $this->keyGroup = $keyGroup;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getUrl() {
	    return $this->url;
	}
	
	
	/**
	 * @param string $url 
	 */
	public function setUrl($url) {
	    $this->url = $url;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getName() {
	    return $this->name;
	}
	
	
	/**
	 * @param string $name 
	 */
	public function setName($name) {
	    $this->name = $name;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getIdParent() {
	    return $this->idParent;
	}
	
	
	/**
	 * @param int $idParent 
	 */
	public function setIdParent($idParent) {
	    $this->idParent = $idParent;
	    return $this;
	}
}