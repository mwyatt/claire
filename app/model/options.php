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
