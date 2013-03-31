<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 			
class Model_mainOption extends Model
{	


	/**
	 * returns class title
	 */
	public function getClassTitle()
	{		
	
		return __CLASS__;
		
	}
	

	/**
	 */	
	public function select()
	{		
	
		$sth = $this->database->dbh->query("	
			SELECT
				name, value
			FROM
				main_option
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->data[$row['name']] = $row['value'];
	
		}			
		
		return $this;
	}
	
	
}
