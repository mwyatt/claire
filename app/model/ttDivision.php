<?php

/**
 * ttDivision
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class ttDivision extends Model
{	
	
	/* Create
	======================================================================== */
	
	/* Read
	======================================================================== */

	/**
	 * all divisions
	 */
	public function read()
	{	
	
		$sth = $this->database->dbh->query("	
			select
				tt_division.id
				, tt_division.name
			from
				tt_division
			order by
				tt_division.id
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$this->data[] = $row;
		}	

	}	
	

	/* Update
	======================================================================== */
	
	/* Delete
	======================================================================== */

	/**
	 *
	 */
	public function delete($id)
	{	
	
		$sth = $this->database->dbh->query("
			DELETE FROM
				tt_team
			WHERE
				id = '$id'		
		");
		
		return $sth->rowCount();
		
	}
	
	
		
	

	
	

	
	

	
}