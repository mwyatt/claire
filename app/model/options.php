<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 			
class Options extends Model
{	

	public function __construct($DBH) {
		$this->DBH = $DBH;
	}
	
	
	/**
	 * Searches $this->result for key match
	 * @return value from $this->result
	 * @usage $options->get('site_title')
	 */
	public function get($key)
	{	
		if ($this->result) {
			if ($key) {
				if (array_key_exists($key, $this->result)) {
					return $this->result[$key];
				}
			}
		}
		return false;
	}

	/**
	 * Selects entire Options table
	 * @return result or false
	 */	
	public function select()
	{		
	
		// Query
		$STH = $this->DBH->query("	
			SELECT
				name
				, value
			FROM
				options
		");
		
		// Process Result Rows
		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {			
			$this->setRow(false, $row['name'], $row['value']);
		}			
		
		return $this;
	}
	
	
}
