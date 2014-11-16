<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Model
{	


	public $tableName = 'tennis_team';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Team';


	public $fields = array(
		'id',
		'divisionId',
		'venueId',
		'secretaryId',
		'name',
		'homeWeekday'
	);


	public $weekdays = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday'
	);


	/**
	 * @return array 
	 */
	public function getWeekdays() {
	    return $this->weekdays;
	}
	
	
	/**
	 * @param array $weekdays 
	 */
	public function setWeekdays($weekdays) {
	    $this->weekdays = $weekdays;
	    return $this;
	}


	public function getWeekday($key)
	{
		$weekdays = $this->getWeekdays();
		if (array_key_exists($key, $weekdays)) {
			return $weekdays[$key];
		}
	}
}
