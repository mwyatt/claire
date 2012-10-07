<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 			
class Options extends Model
{	


	/**
	 * returns class title
	 */
	public function getClassTitle()
	{		
	
		return __CLASS__;
		
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
	 * Selects entire Options table
	 * @return result or false
	 */	
	public function select()
	{		
	
		// Query
		$STH = $this->database->dbh->query("	
			SELECT
				name, value
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
