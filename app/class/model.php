<?php

/**
 * Template for all other Models
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Model extends Config
{

	protected $DBH;
	public $result;
	public $resultRow;
	
	
	/**
	 * Set Result Array
	 */
	public function setResult($value)
	{		
		$this->result = $value;
	}
	
	
	/**
	 * Set Single Result Row (Apply Processing)
	 */
	public function setRow($id = false, $key, $value) {
		if ($id)
			$this->result[$id][$key] = $value;
		else
			$this->result[$key] = $value;
	}	
	

	/**
	 * Get Result Array
	 */
	public function getResult($key = false)
	{		
		if ($key) {
			if (array_key_exists($key, $this->result)) {
				return $this->result[$key];
			} else {
				return false;
			}
		}
		return $this->result;
	}
	
	
	/**
	 * Sets next result row or returns false if last result is returned
	 */
	public function nextRow()
	{		
		if ($this->result) {
			if ($this->resultRow = current($this->result)) {
				next($this->result);
				return true;
			} else {
				unset($this->resultRow);
				reset($this->result);
				return false;
			}
		} else {
			return false;
		}
	}
	
	
	/**
	 * Get Single Result Row
	 * Option to get Specific Key
	 */
	public function getRow($key = false) {
		if ($key == 'id')
			return key($this->resultRow);
		if ($key) {
			if (array_key_exists($key, $this->resultRow)) {
				return $this->resultRow[$key];
			} else {
				return false;
			}
		}
		return $this->resultRow;		
	}	
	
}

/*
Example Iterator Usage


/*
$user = new User($DBH);
$user->getUser();

while ($user->nextRow()) {
	echo $user->getRow('email');
}

exit;
*/