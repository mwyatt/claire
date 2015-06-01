<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="menu")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Menu extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
	 * id of the parent menu item
     * @Column(type="integer")
	 * @var int
	 */
	public $idParent;


	/**
	 * name of menu item
     * @Column(type="string", length=128)
	 * @var string
	 */
	public $name;


	/**
	 * url append to abs url
     * @Column(type="string")
	 * @var string
	 */
	public $url;


	/**
	 * group key to tie different menus together
     * @Column(type="string", length=10)
	 * @var string
	 */
	public $keyGroup;


	/**
	 * @return int 
	 */
	public function getId() {
	    return $this->id;
	}


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
