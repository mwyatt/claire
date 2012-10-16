<?php

/**
 * Responsible for Various content types (Projects, Posts and Pages)
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends Model
{	

	/**
	 * Core Select Method
	 */
	public function select($limit = false)
	{	
	
		// Type
		if ($this->getType)
			$type = " AND c.type = '{$this->type}'";
		
		// Limit
		if ($limit)
			$limit = " LIMIT $limit";
		
		// Query
		$STH = $this->database->dbh->query("
			SELECT
				c.id
				, c.title
				, c.title_slug
				, c.html
				, c.type
				, c.date_published
				, c.guid
				, c.status
				, c.user_id
				, cm.media_id
				, m.title AS media_title
				, m.title_slug AS media_filename
			FROM
				main_content AS c
			LEFT JOIN
				main_content_media AS cm ON c.id = cm.content_id				
			LEFT JOIN
				main_media AS m ON cm.media_id = m.id				
			WHERE	
				c.status = 'visible'
			{$type}			
			ORDER BY
				c.date_published DESC		
			{$limit}	
		");		
		
		// Process Result Rows
		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
			$this->setRow($row['id'], $row['id'], $row['id']);
			$this->setRow($row['id'], 'title', $row['title']);
			$this->setRow($row['id'], 'html', $row['html']);		
			$this->setRow($row['id'], 'type', $row['type']);		
			$this->setRow($row['id'], 'date_published', $row['date_published']);		
			$this->setRow($row['id'], 'guid', $row['guid']);		
			$this->setRow($row['id'], 'status', $row['status']);		
			$this->setRow($row['id'], 'user_id', $row['user_id']);			
			if ($row['media_id']) {
				$this->data[$row['id']]['media'][$row['media_id']]['title'] = $row['media_title'];
				$this->data[$row['id']]['media'][$row['media_id']]['filename'] = $row['media_filename'];
			}
		}				
		
		return $this;
	}
	
	
	/**
	  *	@returns true on success false on failure
	  */
	public function delete($id)
	{	
		$STH = $this->database->dbh->query("
			DELETE FROM
				content
			WHERE
				id = '$id'		
		");
		if ($STH->rowCount()) {
			echo 'Success';
		}
		return false;
	}	

	
	/**
	 * @return result or false
	 */
	public function toggleVisibility($id)
	{		
		
		// PDO	
		$PDO = Database::getInstance();
		$STH = $PDO->dbh->query("
			SELECT
				id		
				, status
			FROM
				main_content
			WHERE 
				id = '$id'
		");
		
		// Rows Found
		if ($STH->rowCount()) {
			while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
				
				// Toggle Status
				$status = ($row['status'] == 'invisible' ? 'visible' : 'invisible');
				
				// PDO	
				$PDO = Database::getInstance();
				$STH = $PDO->dbh->query("
					UPDATE
						content
					SET 
						status = '$status'
					WHERE
						id = '$id'
				");	
				
				// Affected Rows
				if ($STH->rowCount()) {
					return $status;
				} else {
					return false;
				}				
			}
		} else {
			return false;
		}		
	}
	
}