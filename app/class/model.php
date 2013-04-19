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
	public $session;
	public $data = array();
	public $dataRow;

	
	public function __construct($database, $config) {
		$this->session = new Session();
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
	 * sets one result row at a time
	 * @param object $sth 
	 */
	public function setDataStatement($sth)
	{		
	
		// no rows
		if (! $sth->rowCount()) 
			return false;

		// some rows
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

			// handle possible meta_name
			if (array_key_exists('meta_name', $row)) {

				// set meta else set full row
				if (array_key_exists($row['id'], $this->data)) {
					$this->data[$row['id']][$row['meta_name']] = $row['meta_value'];
				} else {
					$this->data[$row['id']] = $row;
					$this->data[$row['id']][$row['meta_name']] = $row['meta_value'];
				}

				unset($this->data[$row['id']]['meta_name']);
				unset($this->data[$row['id']]['meta_value']);

			} else {

				$this->data[$row['id']] = $row;

			}

		}

		// correct array keys
		if (count($this->data) > 1) {
			$this->data = array_values($this->data);
		} else {
			$this->data = reset($this->data);
		}

		return true;
		
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
	// public function singletonRow() {
	
	// 	if (count($this->data) == 1)
		
	// 		$this->data = $this->data[key($this->data)];
			
	// }
	
	
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

		if (current($this->data) === false)
			return false;

		if (! is_array(current($this->data))) {

			if ($this->dataRow !== $this->data) {

				$this->dataRow = $this->data;
				return true;

			} else {

				return false;

			}

		}

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
	
	
	/**
	 * checks through form fields for invalid or null data
	 * @param  array $_POST 
	 * @param  array $keys  
	 * @return bool        if all is valid
	 */
	public function validatePost($post, $keys) {
	
		$validity = true;

		foreach ($keys as $key) {
	
			if (array_key_exists($key, $post)) {
				
				if (! $post[$key])
					$validity = false;
				
			}
		
		}

		return $validity;
		
	}	


	/**
	 * checks the validity of an integer
	 * @param  int $value 
	 * @return bool        
	 */
	public function validateInt($value) {

		$value = intval($value);

		if (gettype($value) == 'integer')

			return true;

		else

			return false;

	}

	public function getUploadDir() {

		return $this->getUrl('base') . 'img/upload/';

	}
	

	public function urlFriendly($value = null)
	{
	
		// everything to lower and no spaces begin or end
		$value = strtolower(trim($value));
		
		// adding - for spaces and union characters
		$find = array(' ', '&', '\r\n', '\n', '+',',');
		$value = str_replace ($find, '-', $value);
		
		//delete and replace rest of special chars
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$value = preg_replace ($find, $repl, $value);
		
		//return the friendly str
		return $value; 	
		
	}

	public function getGuid($type, $name, $id) {
		return $this->config->getUrl('base') . $type . '/' . $this->urlFriendly($name) . '-' . $id . '/';
	}

	public function isChecked($key) {
		return (array_key_exists($key, $_POST) ? $_POST[$key] : false);
	}




	/**
	 * pairs meta values with corresponding rows
	 * this requires the key 'id' to function
	 * @param  array $rows full set of data which needs pairing
	 * @return bool       
	 */
	public function parseMeta($rows) {
		$parsedRows = array();
		foreach ($rows as $key => $row) {
			if (! array_key_exists('id', $row) || ! array_key_exists('meta_name', $row)) {
				return false;
			}
			if (array_key_exists($row['id'], $parsedRows)) {
				$parsedRows[$row['id']][$row['meta_name']] = $row['meta_value'];
			} else {
				$parsedRows[$row['id']] = $row;
				$parsedRows[$row['id']][$row['meta_name']] = $row['meta_value'];
				unset($parsedRows[$row['id']]['meta_name']);
				unset($parsedRows[$row['id']]['meta_value']);
			}
		}
		$parsedRows = array_values($parsedRows);
		$parsedRows = reset($parsedRows);
		return $parsedRows;
	}
	
}