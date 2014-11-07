<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Meta extends OriginalAppName\Entity
{


	/**
	 * key to represent the connection
	 * @var string
	 */
	protected $name;

	
	/**
	 * value often connecting to another row in another table
	 * @var bool|int|string 
	 */
	protected $value;


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
	 * @return bool|int|string 
	 */
	public function getValue() {
	    return $this->value;
	}
	
	
	/**
	 * @param bool|int|string $value 
	 */
	public function setValue($value) {
	    $this->value = $value;
	    return $this;
	}
}
