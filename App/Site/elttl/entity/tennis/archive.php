<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * used only to extend this common column
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Archive extends \OriginalAppName\Entity
{


	/**
	 * the year in which this data is relevant
	 * @var int
	 */
	private $yearId;


	/**
	 * the id which ties in a row to a particular time
	 * will always need to be used in conjunction with yearId
	 * @todo was this a good idea?
	 * @var int
	 */
	private $archiveId;


	/**
	 * @return int 
	 */
	public function getYearId() {
	    return $this->yearId;
	}
	
	
	/**
	 * @param int $yearId 
	 */
	public function setYearId($yearId) {
	    $this->yearId = $yearId;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getArchiveId() {
	    return $this->archiveId;
	}
	
	
	/**
	 * @param int $archiveId 
	 */
	public function setArchiveId($archiveId) {
	    $this->archiveId = $archiveId;
	    return $this;
	}
}
