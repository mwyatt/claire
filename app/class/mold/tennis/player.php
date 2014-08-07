<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Tennis_Player extends Mold
{

	
	public $team_id;

	
	public $name_first;

	
	public $name_last;

	
	public $rank;

	
	public $phone_landline;

	
	public $phone_mobile;

	
	public $etta_license_number;


	/**
	 * @return int 
	 */
	public function getTeamId() {
	    return $this->team_id;
	}
	
	
	/**
	 * @param int $team_id 
	 */
	public function setTeamId($team_id) {
	    $this->team_id = $team_id;
	    return $this;
	}


	/**
	 * first and last name combined with a space
	 * @return string 
	 */
	public function getNameFull() {
	    return $this->name_first . ' ' . $this->name_last;
	}
}
