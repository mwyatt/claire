<?php

namespace OriginalAppName\Entity\Content;


/**
 * @Entity @Table(name="contentMeta")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Meta extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
     * @Column(type="integer")
	 * @var int
	 */
	protected $contentId;	


	/**
	 * key to represent the connection
     * @Column(type="string")
	 * @var string
	 */
	protected $name;

	
	/**
	 * value often connecting to another row in another table
     * @Column(type="string")
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


	/**
	 * @return inst 
	 */
	public function getContentId() {
	    return $this->contentId;
	}
	
	
	/**
	 * @param inst $contentId 
	 */
	public function setContentId($contentId) {
	    $this->contentId = $contentId;
	    return $this;
	}
}
