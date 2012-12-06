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
class mainContent extends Model
{	

	public function read()
	{	
	
		$sth = $this->database->dbh->query("	

			select
				main_content.id
				, main_content.title
				, main_content.title_slug
				, main_content.html
				, main_content.type
				, main_content.date_published
				, main_content.guid
				, main_content.status
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value

			from main_content

			left join
				main_content_meta on main_content_meta.content_id = main_content.id

			left join
				main_user on main_user.id = main_content.user_id

			order by
				main_content.date_published

		");

		$this->setDataStatement($sth);

	}	


	public function readByType($type)
	{	
	
		$sth = $this->database->dbh->prepare("	

			select
				main_content.id
				, main_content.title
				, main_content.title_slug
				, main_content.html
				, main_content.date_published
				, main_content.guid
				, main_content.status
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value

			from main_content

			left join
				main_content_meta on main_content_meta.content_id = main_content.id

			left join
				main_user on main_user.id = main_content.user_id

			where
				main_content.type = :type

			order by
				main_content.date_published

		");

		$sth->execute(array(
			':type' => $type
		));	

		$this->setDataStatement($sth);

	}	


// 	/**
// 	 */
// 	public function select($limit = false)
// 	{	
	
// 	/*
// 			$sth = $this->database->dbh->query("	
// 			SELECT
// 				tt_division.id AS division_id
// 				, tt_team.id AS team_id
// 				, tt_team.name AS team_name
// 				, tt_player.id AS player_id
// 				, tt_player.first_name AS player_first_name
// 				, tt_player.last_name AS player_last_name
// 			FROM
// 				tt_division
// 			LEFT JOIN
// 				tt_team ON tt_team.division_id = tt_division.id
// 			LEFT JOIN
// 				tt_player ON tt_player.team_id = tt_team.id
// 		");
		
// 		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
// 			$this->data[$row['division_id']][$row['team_name']][$row['player_id']]['full_name'] = $row['player_first_name'] . ' ' . $row['player_last_name'];
	
// 		}	

// 	*/
	
// 		// Limit
// 		if ($limit)
// 			$limit = " LIMIT $limit";


// 		// Query
// 		$sth = $this->database->dbh->query("
// 			SELECT
// 				main_content.id AS content_id
// 				, main_content.title AS content_title
// 				, main_content.title_slug AS content_title_slug
// 				, main_content.html AS content_html
// 				, main_content.type AS content_type
// 				, main_content.date_published AS content_date_published
// 				, main_content.guid AS content_guid
// 				, main_content.status AS content_status
// 				, main_media.id AS media_id
// 				, main_media.title AS media_title
// 				, main_media.description AS media_description
// 				, main_media.title_slug AS media_title_slug
// 				, main_media.type AS media_type
// 				, main_user_meta.name AS user_meta_name
// 				, main_user_meta.value AS user_meta_value
// 				, main_content_media.position AS content_media_position
// 			FROM
// 				main_content
// 			LEFT JOIN
// 				main_content_media ON main_content_media.content_id = main_content.id
// 			LEFT JOIN
// 				main_content_media ON main_content_media.media_id = main_media.id
// 			LEFT JOIN
// 				main_media ON main_content_media.media_id = main_media.id
// 			LEFT JOIN
// 				main_user ON main_content.user_id = main_user.id
// 			LEFT JOIN
// 				main_user_meta ON main_user_meta.user_id = main_user.id
// 			WHERE
// 				main_content.type = 'post'
// 			ORDER BY
// 				main_content.date_published DESC
// 				, main_content_media.position DESC				
// 		");		
		
// 		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
// 			$this->data[$row['content_id']] = array(
// 				'title' => $row['content_title'],
// 				'title_slug' => $row['content_title_slug'],
// 				'html' => $row['content_html']	
// 			);
		
// 			$this->data[$row['content_id']]['media'][$row['media_id']] = array(
// 				'title' => $row['media_title'],
// 				'description' => $row['media_description'],
// 				'filename' => $row['media_title_slug'] . '.' . $row['media_type']
// 			);
			
// 		}

// echo '<pre>';
// print_r ($this->data		);
// echo '</pre>';
// exit;

		
		
// 		/*
// 		// Process Result Rows
// 		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
// 			$this->setRow($row['id'], $row['id'], $row['id']);
// 			$this->setRow($row['id'], 'title', $row['title']);
// 			$this->setRow($row['id'], 'html', $row['html']);		
// 			$this->setRow($row['id'], 'type', $row['type']);		
// 			$this->setRow($row['id'], 'date_published', $row['date_published']);		
// 			$this->setRow($row['id'], 'guid', $row['guid']);		
// 			$this->setRow($row['id'], 'status', $row['status']);		
// 			$this->setRow($row['id'], 'user_id', $row['user_id']);			
// 			if ($row['media_id']) {
// 				$this->data[$row['id']]['media'][$row['media_id']]['title'] = $row['media_title'];
// 				$this->data[$row['id']]['media'][$row['media_id']]['filename'] = $row['media_filename'];
// 			}
// 		}*/				
		
// 		return $this;
// 	}
	
	
// 	/**
// 	  *	@returns true on success false on failure
// 	  */
// 	public function delete($id)
// 	{	
// 		$STH = $this->database->dbh->query("
// 			DELETE FROM
// 				content
// 			WHERE
// 				id = '$id'		
// 		");
// 		if ($STH->rowCount()) {
// 			echo 'Success';
// 		}
// 		return false;
// 	}	

	
// 	/**
// 	 * @return result or false
// 	 */
// 	public function toggleVisibility($id)
// 	{		
		
// 		// PDO	
// 		$PDO = Database::getInstance();
// 		$STH = $PDO->dbh->query("
// 			SELECT
// 				id		
// 				, status
// 			FROM
// 				main_content
// 			WHERE 
// 				id = '$id'
// 		");
		
// 		// Rows Found
// 		if ($STH->rowCount()) {
// 			while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
				
// 				// Toggle Status
// 				$status = ($row['status'] == 'invisible' ? 'visible' : 'invisible');
				
// 				// PDO	
// 				$PDO = Database::getInstance();
// 				$STH = $PDO->dbh->query("
// 					UPDATE
// 						content
// 					SET 
// 						status = '$status'
// 					WHERE
// 						id = '$id'
// 				");	
				
// 				// Affected Rows
// 				if ($STH->rowCount()) {
// 					return $status;
// 				} else {
// 					return false;
// 				}				
// 			}
// 		} else {
// 			return false;
// 		}		
// 	}
	
}