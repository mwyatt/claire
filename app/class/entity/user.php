<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends OriginalAppName\Entity
{


	/**
	 * email address for the user, also used for logging in
	 * @var string
	 */
	private $email;


	/**
	 * password for the user stored as sha5
	 * @var string
	 */
	private $password;


	/**
	 * first name
	 * @var string
	 */
	private $nameFirst;


	/**
	 * last name
	 * @var string
	 */
	private $nameLast;


	/**
	 * epoch time of registering
	 * @var int
	 */
	private $timeRegistered;


	/**
	 * value for determining the permissions
	 * @var int
	 */
	private $level;


	/**
	 * @return string 
	 */
	public function getEmail() {
	    return $this->email;
	}
	
	
	/**
	 * @param string $email 
	 */
	public function setEmail($email) {
	    $this->email = $email;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getPassword() {
	    return $this->password;
	}
	
	
	/**
	 * @param string $password 
	 */
	public function setPassword($password) {
	    $this->password = $password;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getNameFirst() {
	    return $this->nameFirst;
	}
	
	
	/**
	 * @param string $nameFirst 
	 */
	public function setNameFirst($nameFirst) {
	    $this->nameFirst = $nameFirst;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getNameLast() {
	    return $this->nameLast;
	}
	
	
	/**
	 * @param string $nameLast 
	 */
	public function setNameLast($nameLast) {
	    $this->nameLast = $nameLast;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getTimeRegistered() {
	    return $this->timeRegistered;
	}
	
	
	/**
	 * @param int $timeRegistered 
	 */
	public function setTimeRegistered($timeRegistered) {
	    $this->timeRegistered = $timeRegistered;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getLevel() {
	    return $this->level;
	}
	
	
	/**
	 * @param int $level 
	 */
	public function setLevel($level) {
	    $this->level = $level;
	    return $this;
	}


	/**
	 * check external password against entity value
	 * @param  string $password has been crypted
	 * @return bool
	 */
	public function validatePassword($password) {
		if (crypt($password, $this->getPassword()) == $this->getPassword()) {
			return true;
		}
	}
}
