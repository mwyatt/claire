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
class Post extends mainContent
{
	
	/**
	 * select all rows match
	 */
	public function select($limit = false)
	{	
	
		$type = strtolower(__CLASS__);	
				
		$sth = $this->database->dbh->query("
			select
				content.id
				, content.title
				, content.title_slug
				, content.html
				, content.type
				, content.date_published
				, content.guid
				, content.status
				, content.user_id
				, content_media.media_id
				, media.title as media_title
				, media.title_slug as media_filename
			from
				content
			left join
				content_media on content.id = content_media.content_id				
			left join
				media as m on content_media.media_id = media.id				
			where	
				content.status = 'visible'
			and
				content.type = 'post'
			order by
				content.date_published desc, content_media.position
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