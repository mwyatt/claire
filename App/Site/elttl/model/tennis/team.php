<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Model
{	


	public $tableName = 'tennisTeam';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Team';


	public $fields = array(
		'id',
		'yearId',
		'name',
		'slug',
		'homeWeekday',
		'secretaryId',
		'venueId',
		'divisionId'
	);


	public $weekdays = array(
		1 => 'Monday',
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday'
	);


	/**
	 * reads any table with yearId and archiveId
	 * gets the segment of interest
	 * @param  int $yearId    
	 * @param  int $archiveId 
	 * @return object            
	 */
	public function readDivisionId($yearId, $divisionArchiveId)
	{
echo '<pre>';
print_r($yearId);
echo '<pre>';
print_r($divisionArchiveId);
echo '</pre>';
exit;

		// query
		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where
            	{$yearId} = :yearId
            	and {$archiveId} = :archiveId
		");

		// mode
		$sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

		// bind
	    $sth->bindValue(':yearId', $yearId, \PDO::PARAM_INT);
	    $sth->bindValue(':archiveId', $archiveId, \PDO::PARAM_INT);

	    // execute
		$sth->execute();

		// store
		$this->setData($sth->fetchAll());

		// instance
		return $this;
	}


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
