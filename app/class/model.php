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
abstract class Model
{

	public $database;
	public $config;
	public $data;
	public $resultRow;

	
	public function __construct($database, $config) {
	
		$this->database = $database;
		$this->config = $config;
		
	}
	
	
	/**
	 * Set Result Array
	 */
	public function setResult($value)
	{		
	
		$this->data = $value;
		
	}
	
	
	/**
	 * Set Single Result Row
	 */
	public function setRow($id = false, $key, $value) {
	
		if ($id)
			$this->data[$id][$key] = $value;
		else
			$this->data[$key] = $value;
			
	}	
	

	/**
	 * Get Result Array
	 */
	public function getResult($key = false)
	{		
		if ($key) {
			if (array_key_exists($key, $this->data)) {
				return $this->data[$key];
			} else {
				return false;
			}
		}
		return $this->data;
	}
	
	
	/**
	 * Sets next result row or returns false if last result is returned
	 */
	public function nextRow()
	{		
		if ($this->data) {
			if ($this->dataRow = current($this->data)) {
				next($this->data);
				return true;
			} else {
				unset($this->dataRow);
				reset($this->data);
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
			return key($this->dataRow);
		if ($key) {
			if (array_key_exists($key, $this->dataRow)) {
				return $this->dataRow[$key];
			} else {
				return false;
			}
		}
		return $this->dataRow;		
	}	
	
}