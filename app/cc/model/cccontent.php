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
class ccContent extends Content
{	
	
	public function __construct($DBH, $type) {
		$this->DBH = $DBH;
		$this->type = $type;
	}
	
	
	/**
	 * Select
	 */
	public function select($limit = false, $id = false)
	{	
		// Type
		if ($this->type)
			$type = " AND c.type = '{$this->type}'";
		
		// Limit
		if ($limit)
			$limit = " LIMIT $limit";

		// id
		if ($id)
			$id = " WHERE c.id = $id";
		
		// Query
		$STH = $this->DBH->query("
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
				, m.type AS media_type
				, m.description AS media_description
				, m.guid AS media_guid
			FROM
				content AS c
			LEFT JOIN
				content_media AS cm ON c.id = cm.content_id				
			LEFT JOIN
				media AS m ON cm.media_id = m.id				
			{$id}			
			{$type}			
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
				$this->result[$row['id']]['media'][$row['media_id']]['title'] = $row['media_title'];
				$this->result[$row['id']]['media'][$row['media_id']]['description'] = $row['media_description'];
				$this->result[$row['id']]['media'][$row['media_id']]['guid'] = $row['media_guid'];
			}
		}				
		
		return $this;
	}
	
}