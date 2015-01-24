<?php

namespace OriginalAppName\Entity\Log\Admin;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Unseen extends OriginalAppName\Entity
{


	private $logId;


	private $userId;


	/**
	 * @return int 
	 */
	public function getLogId() {
	    return $this->logId;
	}
	
	
	/**
	 * @param int $logId 
	 */
	public function setLogId($logId) {
	    $this->logId = $logId;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getUserId() {
	    return $this->userId;
	}
	
	
	/**
	 * @param int $userId 
	 */
	public function setUserId($userId) {
	    $this->userId = $userId;
	    return $this;
	}
}
