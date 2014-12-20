<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Site\Elttl\Entity\Tennis\Archive
{

	
	private $divisionArchiveId;

	
	private $venueArchiveId;

	
	private $secretaryId;

	
	private $name;


	private $slug;

	
	private $homeWeekday;


	/**
	 * @return int 
	 */
	public function getDivisionId() {
	    return $this->divisionId;
	}
	
	
	/**
	 * @param int $divisionId 
	 */
	public function setDivisionId($divisionId) {
	    $this->divisionId = $divisionId;
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
	 * @return string 
	 */
	public function getSlug() {
	    return $this->slug;
	}
	
	
	/**
	 * @param string $slug 
	 */
	public function setSlug($slug) {
	    $this->slug = $slug;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getHomeWeekday() {
	    return $this->homeWeekday;
	}
	
	
	/**
	 * @param int $homeWeekday 
	 */
	public function setHomeWeekday($homeWeekday) {
	    $this->homeWeekday = $homeWeekday;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getVenueId() {
	    return $this->venueId;
	}
	
	
	/**
	 * @param int $venueId 
	 */
	public function setVenueId($venueId) {
	    $this->venueId = $venueId;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getSecretaryId() {
	    return $this->secretaryId;
	}
	
	
	/**
	 * @param int $secretaryId 
	 */
	public function setSecretaryId($secretaryId) {
	    $this->secretaryId = $secretaryId;
	    return $this;
	}


	/**
	 * @return array 
	 */
	public function getWeekdays() {
	    return array(
			1 => 'Monday',
			2 => 'Tuesday',
			3 => 'Wednesday',
			4 => 'Thursday',
			5 => 'Friday'
		);
	}
	
	
	/**
	 * @param array $weekdays 
	 */
	public function setWeekdays($weekdays) {
	    $this->weekdays = $weekdays;
	    return $this;
	}
	

	/**
	 * weekday as string
	 * @return string 
	 */
	public function getHomeWeekdayName()
	{
		$weekdays = $this->getWeekdays();
		$key = $this->getHomeWeekday();
		if (arrayKeyExists($key, $weekdays)) {
			return $weekdays[$key];
		}
	}
}
