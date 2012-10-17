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
abstract class Model extends Config
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
	 * Get data array or by key
	 */
	public function getData($key = false)
	{		
		if ($key) {
		
			if (array_key_exists($key, $this->data))
			
				return $this->data[$key];
				
			else
			
				return false;
			
		}
		
		return $this->data;
		
	}	
	
	
	/**
	 * Set data array
	 */
	public function setData($value)
	{		
	
		$this->data = $value;
		
	}
	
	
	/**
	 * convert only one result to singleton pattern
	 */
	public function singletonRow() {
	
		if (count($this->data) == 1)
		
			$this->data = $this->data[key($this->data)];
			
	}
	
	
	/**
	 * use sth to parse rows combining meta data and store in $data
	 */
	public function parseRows($sth) {
	
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			foreach ($row as $key => $value) {
			
				$this->data[$row['id']][$key] = $value;
				
			}
		
			if (array_key_exists('meta_name', $row))
				$this->data[$row['id']][$row['meta_name']] = $row['meta_value'];
		
			if (array_key_exists($name = 'meta_name', $this->data[$row['id']]))
				unset($this->data[$row['id']][$name]);
				
			if (array_key_exists($name = 'meta_value', $this->data[$row['id']]))
				unset($this->data[$row['id']][$name]);
				
			
		}
		
		if (count($this->data) == 1)
			$this->data = $this->data[key($this->data)];
		
	}	
	
	
	/**
	 * Searches $this->data for key match
	 * @return value from $this->data
	 * @usage $options->get('site_title')
	 */
	public function get($key)
	{	
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}
		return false;
	}	

	
	/**
	 * Sets next result row or returns false if last result is returned
	 */
	public function nextRow()
	{		

		if ($this->dataRow = current($this->data)) {
		
			next($this->data);
			
			return true;
			
		} else {
		
			unset($this->dataRow);
			
			reset($this->data);
			
			return false;
			
		}
				
	}
	
	
	/**
	 * Get Single Result Row
	 * Option to get Specific Key
	 */
	public function getRow($key = false) {
	
		if ($key) {
		
			if (array_key_exists($key, $this->dataRow))	
			
				return $this->dataRow[$key];
				
			else
			
				return false;
				
		}
		
		return $this->dataRow;
		
	}	
	
}