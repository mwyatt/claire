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
	
	public $type;
	
	
	/**
	 * Core Select Method
	 * type, limit, date, media, user
	 */
	public function select($limit = false)
	{	
	
		// Type
		if ($this->type)
			$type = " AND c.type = '{$this->type}'";
		
		// Limit
		if ($limit)
			$limit = " LIMIT $limit";
		
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
				, m.title_slug AS media_filename
			FROM
				content AS c
			LEFT JOIN
				content_media AS cm ON c.id = cm.content_id				
			LEFT JOIN
				media AS m ON cm.media_id = m.id				
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
				$this->result[$row['id']]['media'][$row['media_id']]['title'] = $row['media_title'];
				$this->result[$row['id']]['media'][$row['media_id']]['filename'] = $row['media_filename'];
			}
		}				
		
		return $this;
	}
	
	
	/**
	  *
	  *//*
	public function selectJoin()
	{	
		$STH = $this->DBH->query("
			SELECT
				id
				, title
				, title_slug
				, html
				, type
				, date_published
				, guid
				, status
				, tags
			FROM
				content
			LEFT JOIN
				content_media
			ON
				content.id = contentMedia.contentId
		");
		$this->setResult(
			$this->setResultRows($STH)
		);				
	}*/	
	
	
	/**
	  *	@returns true on success false on failure
	  */
	public function delete($id)
	{	
		$STH = $this->DBH->query("
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
	 * Get options array value
	 *
	 * @param string $key The array key to return
	 * @return string|false The array value or false if it does not exist
	 */	
	public function countRows($type = false)
	{
		if ($type) {
			$STH = $DBH->query("
				SELECT
					COUNT(id)
				FROM
					content
				WHERE
					type = 'post'
				AND
					status = 'visible'
				ORDER BY
					date_published DESC
			");

			$count = $STH->fetch(PDO::FETCH_NUM);

			echo '<pre>';
			print_r ($count);
			echo '</pre>';
			exit;				
		
			return $count;
		}
		return false;
	}	
	
	
	public function selectTitle($titleSlug, $limit = 0)
	{	
		$SQL = "
			SELECT
				`id`
				,`title`
				,`title_slug`
				,`html`
				,`type`
				,`date_published`
				,`guid`
				,`status`
				,`tags`
				,`attached`
			"
			. " FROM content"
			. " WHERE title_slug = '$titleSlug'"
		;		
		
		// extend sql
		$SQL .= " ORDER BY date_published DESC";
		$SQL .= ($limit != false ? " LIMIT $limit" : "");
		
		// Execute
		$STH = $this->DBH->query($SQL);
		
		// Set Result
		$this->setResult(
			$this->setResultRows($STH)
		);
		
		return $this;
	}
	

	public function setResultRows($STH)
	{
		// Rows Found
		if ($STH->rowCount()) {
			while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
				$row['attached'] = $this->explodeComma($row['attached']);
				$results[] = $row;
			}
			return $results;
		} else {
			return false;
		}
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
				content
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
	
	
	/**
	 * Explode @param val and reset array keys
	 * @return @param val or false
	 */
	public function explodeComma($val)
	{	
		if ($val) {
			
			// Split Via ', '
			$val = explode(', ', $val);

			// Reset Keys
			$val = array_values($val);						
		} else {
		
			// Return
			return false;
		}							
				
		// Return
		return $val;
	}	
	
	
	/**
	  *	@return result or false
	  */
	public function getDate($year = null, $month = null, $type = null, $title = null, $limit = null)
	{		
		if (!is_numeric($year) && ($year !== null)) { return false; }
		if (!is_numeric($month) && ($month !== null)) { return false; }
	
		$pdo = Database::getInstance(); // instance db
		$sql = "
			SELECT
				id			
				,title
				,title_slug
				,type
				,date_published
				,guid
				,status
				,tags
				,attached
				,nav_order
				,nav_parent_id
			FROM
				content
		"; // base sql
		$sql .= ($type != null ? "\n\n"."WHERE type = '$type'" : false);
		$sql .= "\n\n"."AND status = 'visible'";
		$sql .= ($year != null ? "\n\n"."AND EXTRACT(year FROM date_published) = '$year'" : "");
		$sql .= ($month != null ? "\n\n"."AND EXTRACT(month FROM date_published) = '$month'" : false);
		$sql .= ($title != null ? "\n\n"."AND title_slug = '$title'" : false);
		$sql .= "\n\n"."ORDER BY date_published DESC";
		$sql .= ($limit != null ? "\n\n"."LIMIT $limit" : "");		

		$sth = $pdo->dbh->query($sql); // execute sql		
		
		$type = ($type !== null ? $type.'s' : null); // add 's'
		
		if ($sth->rowCount() > 0) { // result check
			$this->setResult($sth->fetchAll(PDO::FETCH_ASSOC)); // set result			
		} else {
			return false;
		}		
		return $this->result;			
	}	
	
	/**
	  *	@param null
	  *	@return result or false
	  */
	public function getTag($title = null)
	{
		$pdo = Database::getInstance(); // instance db
		$sql = "
			SELECT
				title
				,date_published
				,type
				,guid
				,status
				,tags
				,attached
			FROM
				content
			WHERE
				status = 'visible'
		"; // base sql
		
		$sth = $pdo->dbh->query($sql); // execute sql
				
		if ($sth->rowCount() > 0) { // result check
			$this->setResult($sth->fetchAll(PDO::FETCH_ASSOC)); // set result			
			for ($i = 0; $i < count($this->getResult()) ; $i++) { // result loop
				if ($this->hasTag($title, $this->result[$i]['tags'])) {	
					// unserialize attached
					$this->result[$i]['attached'] = ($this->result[$i]['attached'] !== null ? Database::unserialize($this->result[$i]['attached']) : null);
					// tags
					$this->result[$i]['tags'] = $this->setTags($this->result[$i]['tags'], $title);
					$tagMatch[$this->result[$i]['type']][] = $this->result[$i]; // set new array of matches
				}
			}
			$this->setResult($tagMatch); // set tag match results
		} else {
			return false;
		}		
		return $this->result;
	}

	/**
	  * check for tag match
	  */
	public function hasTag($title, $str)
	{		
		$slices = explode(', ', $str); // split via ', '
		foreach ($slices as $slice) {
			if (Database::friendly_url($slice) == $title) {
				return true;	
			}
		}	
		return false;
	}

	
	/**
	  * builds a name, url tag array and returns
	  */
	public function setTags($str, $exclude = null)
	{		
		$slices = explode(', ', $str); // split via ', '
		$base = Config::getUrl('base').'tags/';
		$tags = array();
		foreach ($slices as $slice) {
			$tag = Database::friendly_url($slice);
			
			if ($tag !== $exclude) {
				$tags[] = array(
					'name' => $slice,
					'url' => $base.$tag.'/'
				);			
			}
		}			
		return ($tags ? $tags : false);
	}	
	
	
	/**
	  * Interfaces with the 'attachments' model to grab the attachments required
	  * @param attachments is used to inject attachments into $this->result
	  */
	public function setAttached($thumb = null, $results = false)
	{
		
		// Object(s)
		$attachments = new Attachments($this->DBH);
		
		// Select Attachments Based on @param result
		$attachments->selectUnique($this->getResult());
		
		// Append Attachments
		if ($this->getResult() && $attachments->getResult()) :
			foreach ($this->getResult() as $result) :
				$results[] = $attachments->append($result, $thumb);
			endforeach;
		endif;			
		
		// Overwrite result
		$this->setResult($results);
		
		return $this->getResult();
	}
	
	
}