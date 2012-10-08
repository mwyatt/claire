<?php

/**
 * Post
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Post extends Content
{
	
	/**
	 * 
	 */
	public function select($limit = false)
	{	
	
		$type = strtolower(__CLASS__);	
				
		$sth = $this->database->dbh->query("
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
				content AS c
			LEFT JOIN
				content_media AS cm ON c.id = cm.content_id				
			LEFT JOIN
				media AS m ON cm.media_id = m.id				
			WHERE	
				c.status = 'visible'
			AND
				c.type = '{$type}'
			ORDER BY
				c.date_published DESC		
		");		
		
		$this->parseRows($sth);
	


		
		/*
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
		}	*/			
		
		return $this;
	}
				
}