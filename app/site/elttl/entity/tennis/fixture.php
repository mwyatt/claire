<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Entity\Tennis\Archive
{

	
	private $teamArchiveIdLeft;

	
	private $teamArchiveIdRight;

	
	private $timeFulfilled;


	/**
	 * @return int 
	 */
	public function getTeamIdLeft() {
	    return $this->teamIdLeft;
	}
	
	
	/**
	 * @param int $teamIdLeft 
	 */
	public function setTeamIdLeft($teamIdLeft) {
	    $this->teamIdLeft = $teamIdLeft;
	    return $this;
	}


	/**
	 * @return int
	 */
	public function getTeamIdRight() {
	    return $this->teamIdRight;
	}
	
	
	/**
	 * @param int $teamIdRight
	 */
	public function setTeamIdRight($teamIdRight) {
	    $this->teamIdRight = $teamIdRight;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getTimeFulfilled() {
	    return $this->timeFulfilled;
	}
	
	
	/**
	 * @param int $timeFulfilled 
	 */
	public function setTimeFulfilled($timeFulfilled) {
	    $this->timeFulfilled = $timeFulfilled;
	    return $this;
	}
}
