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
}
