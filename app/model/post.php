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
	 * select all rows match
	 */
	public function select($limit = false)
	{	
	
		$type = strtolower(__CLASS__);	
				
		$sth = $this->database->dbh->query("
			select
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
				, m.title as media_title
				, m.title_slug as media_filename
			from
				content as c
			left join
				content_media as cm on c.id = cm.content_id				
			left join
				media as m on cm.media_id = m.id				
			where	
				c.status = 'visible'
			and
				c.type = 'post'
			order by
				c.date_published desc, cm.position
		");		
		
		$this->parseRows($sth);
		
		return $this;
		
	}
	
	
	/**
	 * custom parse
	 */
	public function parseRows($sth) {
	
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			foreach ($row as $key => $val) {
				
				$this->data[$row['id']][$key] = $val;
			
			}
			
			if (array_key_exists('media_id', $row)) {
			
				if ($row['media_id']) {
			
					$this->data[$row['id']]['media'][$row['media_id']]['title'] = $row['media_title'];
					
					$this->data[$row['id']]['media'][$row['media_id']]['filename'] = $row['media_filename'];
					
				}
				
			}			
		
			unset($this->data[$row['id']]['media_id']);
			unset($this->data[$row['id']]['media_title']);
			unset($this->data[$row['id']]['media_filename']);
		
		}
		
		$this->singletonRow();
		
	}		
				
}