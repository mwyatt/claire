<?php

namespace OriginalAppName\Entity;


/**
 * combines any two tables together in association
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Meta extends \OriginalAppName\Entity
{


	public $leftId;
	

	public $leftTable;


	public $rightId;
	

	public $rightTable;


	/**
	 * @return int 
	 */
	public function getLeftId() {
	    return $this->leftId;
	}
	
	
	/**
	 * @param int $leftId 
	 */
	public function setLeftId($leftId) {
	    $this->leftId = $leftId;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getLeftTable() {
	    return $this->leftTable;
	}
	
	
	/**
	 * @param string $leftTable 
	 */
	public function setLeftTable($leftTable) {
	    $this->leftTable = $leftTable;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getRightId() {
	    return $this->rightId;
	}
	
	
	/**
	 * @param int $rightId 
	 */
	public function setRightId($rightId) {
	    $this->rightId = $rightId;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getRightTable() {
	    return $this->rightTable;
	}
	
	
	/**
	 * @param string $rightTable 
	 */
	public function setRightTable($rightTable) {
	    $this->rightTable = $rightTable;
	    return $this;
	}
}
