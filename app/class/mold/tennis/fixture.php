<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Tennis_Fixture extends Mold
{

	
	public $team_id_left;

	
	public $team_id_right;

	
	public $time_fulfilled;


	/**
	 * @return int 
	 */
	public function getTeamIdLeft() {
	    return $this->team_id_left;
	}
	
	
	/**
	 * @param int $teamIdLeft 
	 */
	public function setTeamIdLeft($teamIdLeft) {
	    $this->team_id_left = $teamIdLeft;
	    return $this;
	}


	/**
	 * @return int
	 */
	public function getTeamIdRight() {
	    return $this->team_id_right;
	}
	
	
	/**
	 * @param int $teamIdRight
	 */
	public function setTeamIdRight($teamIdRight) {
	    $this->team_id_right = $teamIdRight;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getTimeFulfilled() {
	    return $this->time_fulfilled;
	}
	
	
	/**
	 * @param int $timeFulfilled 
	 */
	public function setTimeFulfilled($timeFulfilled) {
	    $this->time_fulfilled = $timeFulfilled;
	    return $this;
	}
}
