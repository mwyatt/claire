<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="options")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Option extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
	 * key to represent the connection
     * @Column(type="string")
	 * @var string
	 */
	public $name;

	
	/**
	 * value often connecting to another row in another table
     * @Column(type="string")
	 * @var bool|int|string 
	 */
	public $value;


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
