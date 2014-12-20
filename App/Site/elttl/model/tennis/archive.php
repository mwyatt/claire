<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Archive extends \OriginalAppName\Model
{	


	/**
	 * reads any table with yearId and archiveId
	 * gets the segment of interest
	 * @param  int $yearId    
	 * @param  int $archiveId 
	 * @return object            
	 */
	public function readYearArchive($yearId, $archiveId)
	{
echo '<pre>';
print_r($yearId);
echo '<pre>';
print_r($archiveId);
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
}
