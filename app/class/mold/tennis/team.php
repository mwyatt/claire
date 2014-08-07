<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Tennis_Team extends Mold
{

	
	public $division_id;

	
	public $venue_id;

	
	public $secretary_id;

	
	public $name;

	
	public $home_weekday;


	/**
	 * @return int 
	 */
	public function getDivisionId() {
	    return $this->division_id;
	}
	
	
	/**
	 * @param int $division_id 
	 */
	public function setDivisionId($division_id) {
	    $this->division_id = $division_id;
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
}
