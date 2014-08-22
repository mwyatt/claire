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


	/**
	 * @return int 
	 */
	public function getHomeWeekday() {
	    return $this->home_weekday;
	}
	
	
	/**
	 * @param int $homeWeekday 
	 */
	public function setHomeWeekday($homeWeekday) {
	    $this->home_weekday = $homeWeekday;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getVenueId() {
	    return $this->venue_id;
	}
	
	
	/**
	 * @param int $venueId 
	 */
	public function setVenueId($venueId) {
	    $this->venue_id = $venueId;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getSecretaryId() {
	    return $this->secretary_id;
	}
	
	
	/**
	 * @param int $secretaryId 
	 */
	public function setSecretaryId($secretaryId) {
	    $this->secretary_id = $secretaryId;
	    return $this;
	}
}
