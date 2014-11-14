<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Log extends OriginalAppName\Entity
{


	private $message;


	private $time;


	private $type;


	private $userId;


	/**
	 * @return string 
	 */
	public function getMessage() {
	    return $this->message;
	}
	
	
	/**
	 * @param string $message 
	 */
	public function setMessage($message) {
	    $this->message = $message;
	    return $this;
	}


	/**
	 * @return int epoc
	 */
	public function getTime() {
	    return $this->time;
	}
	
	
	/**
	 * @param int $time epoc
	 */
	public function setTime($time) {
	    $this->time = $time;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getType() {
	    return $this->type;
	}
	
	
	/**
	 * @param string $type 
	 */
	public function setType($type) {
	    $this->type = $type;
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
