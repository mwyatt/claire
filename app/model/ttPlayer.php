<?php

/**
 * ttPlayer
 *
 * create
 * read
 * update
 * delete
 * 
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Ttplayer extends Model
{		


	public function create() {	
		if (! $this->validatePost($_POST, array('first_name', 'last_name', 'rank'))) {
			$this->session->set('feedback', 'All required fields must be filled');
			return false;
		}
		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tt_player
				(first_name, last_name, rank, team_id)
			VALUES
				(:first_name, :last_name, :rank, :team_id)
		");				
		$sth->execute(array(
			':first_name' => (array_key_exists('first_name', $_POST) ? $_POST['first_name'] : '')
			, ':last_name' => (array_key_exists('last_name', $_POST) ? $_POST['last_name'] : '')
			, ':rank' => (array_key_exists('rank', $_POST) ? $_POST['rank'] : '')
			, ':team_id' => (array_key_exists('team_id', $_POST) ? $_POST['team_id'] : '')
		));	

		if ($sth->rowCount()) {
			$this->session->set('feedback', 'Success, player "' . $_POST['first_name'] . ' ' . $_POST['last_name'] . '" created');
			return $this->database->dbh->lastInsertId();
		}
		$this->session->set('feedback', 'Problem while creating player');
		return false;
	}


	public function readTop($divisionId, $limit = 0)
	{/*
		$sth = $this->database->dbh->prepare("	
			select
				(Count(Grade)* 100 / (Select Count(*) From MyTable)) as Score



				tt_player.id
				, tt_player.rank
				, tt_player.first_name
				, tt_player.last_name
				, concat(tt_player.first_name, ' ', tt_player.last_name) as full_name
				, tt_team.id as team_id
				, tt_division.id as division_id
				, tt_team.name as team_name
				, (sum(case when tt_encounter_result.left_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.left_score else 0 end) + sum(case when tt_encounter_result.right_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.right_score else 0 end)) as won
				, (sum(case when tt_encounter_result.left_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.right_score else 0 end) + sum(case when tt_encounter_result.right_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.left_score else 0 end)) as lost
				, sum(
					case
						when tt_encounter_result.status = '' and tt_encounter_result.left_id = tt_player.id or tt_encounter_result.status = '' and tt_encounter_result.right_id = tt_player.id then tt_encounter_result.left_score + tt_encounter_result.right_score
					else 0
				end) as played
			from tt_player
			left join tt_team on tt_player.team_id = tt_team.id
			left join tt_encounter_result on tt_encounter_result.left_id = tt_player.id or tt_encounter_result.right_id = tt_player.id
			left join tt_division on tt_division.id = tt_team.division_id
			where tt_player.id = ?
			group by tt_player.id
		");
		foreach ($ids as $id) {
			$sth->execute(array($id));
			$player = $sth->fetch(PDO::FETCH_ASSOC);
			$players[$player['id']] = $player;
			$players[$player['id']]['average'] = $this->calcAverage($player['won'], $player['played']);
		}
		if (count($players) == 1) {
			$players = current($players);
		}
		if (! empty($players)) {
			return $this->data = $players;
		}
		return false;
	*/}
	

	public function read()
	{	
	
		$sth = $this->database->dbh->query("	
			select
				tt_player.id
				, tt_player.rank
				, concat(tt_player.first_name, ' ', tt_player.last_name) as full_name
				, tt_team.name as team_name
				, tt_division.name as division_name
			from
				tt_player
			left join tt_team on tt_player.team_id = tt_team.id
			left join tt_division on tt_team.division_id = tt_division.id
			order by
				tt_division.id
				, tt_player.rank desc
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$row['name'] = $row['full_name'];
			$row['guid'] = $this->getGuid('player', $row['full_name'], $row['id']);
			$this->data[] = $row;
		}

		return $sth->rowCount();
	}	



	public function getById($id)
	{		

		if ($this->getData()) {
		
			foreach ($this->getData() as $player) {

				if (array_key_exists('id', $player)) {

					if ($player['id'] == $id)
						
						return $player;

				}
				
			}

		}

		return false;
		
	}	


	/**
	 * select player by id
	 * @param  int $id 
	 * @return bool     
	 */
	public function readById($ids)
	{	
		$sth = $this->database->dbh->prepare("	
			select
				tt_player.id
				, tt_player.rank
				, tt_player.first_name
				, tt_player.last_name
				, concat(tt_player.first_name, ' ', tt_player.last_name) as full_name
				, tt_team.id as team_id
				, tt_division.id as division_id
				, tt_team.name as team_name
				, (sum(case when tt_encounter_result.left_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.left_score else 0 end) + sum(case when tt_encounter_result.right_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.right_score else 0 end)) as won
				, (sum(case when tt_encounter_result.left_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.right_score else 0 end) + sum(case when tt_encounter_result.right_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.left_score else 0 end)) as lost
				, sum(
					case
						when tt_encounter_result.status = '' and tt_encounter_result.left_id = tt_player.id or tt_encounter_result.status = '' and tt_encounter_result.right_id = tt_player.id then tt_encounter_result.left_score + tt_encounter_result.right_score
					else 0
				end) as played
			from tt_player
			left join tt_team on tt_player.team_id = tt_team.id
			left join tt_encounter_result on tt_encounter_result.left_id = tt_player.id or tt_encounter_result.right_id = tt_player.id
			left join tt_division on tt_division.id = tt_team.division_id
			where tt_player.id = ?
			group by tt_player.id
		");
		foreach ($ids as $id) {
			$sth->execute(array($id));
			$player = $sth->fetch(PDO::FETCH_ASSOC);
			$players[$player['id']] = $player;
			$players[$player['id']]['average'] = $this->calcAverage($player['won'], $player['played']);
		}
		if (count($players) == 1) {
			$players = current($players);
		}
		if (! empty($players)) {
			return $this->data = $players;
		}
		return false;
	}	


	/**
	 * all data required to display the merit table
	 * player name, team name, team guid, player rank, sets won, sets played
	 * must exclude matches which have no opponent
	 */
	public function readByTeam($id)
	{	

		$sth = $this->database->dbh->prepare("

			select
				tt_player.id
				, concat(tt_player.first_name, ' ', tt_player.last_name) as full_name
				, tt_team.name as team_name
				, tt_division.name as division_name

			from
				tt_player

			left join
				tt_team on tt_player.team_id = tt_team.id
			left join tt_division on tt_team.division_id = tt_division.id

			where
				tt_team.id = :id

			group by
				tt_player.id

			order by
				tt_player.rank desc

		");				
		
		$sth->execute(array(
			':id' => $id
		));

		$view = new View($this->database, $this->config);

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$row['name'] = $row['full_name'];
			$row['guid'] = $this->getGuid('player', $row['full_name'], $row['id']);
			$this->data[] = $row;
		}

	}	


	/**
	 * read merit data from tt_encounter_part
	 * @param  int $division_id 
	 * @return bool              
	 */
	public function readMerit($divisionId)
	{	
		$sth = $this->database->dbh->prepare("	
			select
				tt_player.id
				, concat(tt_player.first_name, ' ', tt_player.last_name) as full_name
				, tt_team.id as team_id
				, tt_team.name as team_name
				, tt_player.rank
				, (sum(case when tt_encounter_result.left_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.left_score else 0 end) + sum(case when tt_encounter_result.right_id = tt_player.id and tt_encounter_result.status = '' then tt_encounter_result.right_score else 0 end)) as won
				, sum(
					case
						when tt_encounter_result.status = '' and tt_encounter_result.left_id = tt_player.id or tt_encounter_result.right_id = tt_player.id then tt_encounter_result.left_score + tt_encounter_result.right_score
					else 0
				end) as played
			from tt_player
			left join tt_team on tt_team.id = tt_player.team_id
			left join tt_encounter_result on tt_encounter_result.left_id = tt_player.id or tt_encounter_result.right_id = tt_player.id
			where tt_team.division_id = ?
			group by tt_player.id
		");
		$sth->execute(array($divisionId));
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$average = $this->calcAverage($row['won'], $row['played']);
			$averages[$row['id']] = $average;
			$row['guid'] = $this->getGuid('player', $row['full_name'], $row['id']);
			$row['team_guid'] = $this->getGuid('team', $row['team_name'], $row['team_id']);
			$row['average'] = $average . '&#37;';
			if ($row['played']) {
				$this->data[$row['id']] = $row;
			}
		}
		if ($this->data) {
			array_multisort($averages, SORT_DESC, $this->data);
			return $this->data;
		} else {
			return false;
		}
	}	


	/**
	 * calculates the average 0 to 100%
	 * @param  int $won    
	 * @param  int $played 
	 * @return int         percentage value of win / loss ratio
	 */
	public function calcAverage($won, $played) {
		
		$average = 0;

		if ( $played != 0 ) {
			$x = 0; $y = 0; $average = 0;			
			$x = $won / $played;
			$y = $x * 100;
			$average = round($y);
		}
		
	    return $average;
		
	} 



	public function updateRank($playerId, $rankChange) {
		$sth = $this->database->dbh->prepare("	
			select
				tt_player.rank
			from
				tt_player
			where
				id = :id
		");
		$sth->execute(array(':id' => $playerId));
		if ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$currentRank = $row['rank'];
		}						
		$sth = $this->database->dbh->prepare("
			update
				tt_player
			set 
				rank = :rank
			where
				id = :id
		");	
		$sth->execute(array(
			':rank' => $currentRank + $rankChange
			, ':id' => $playerId
		));
	}	
	
	
	public function getRankChange($rankLeft, $rankRight, $winner) {
		if ($rankLeft > $rankRight) {
			$rankDifference = $rankLeft - $rankRight;
		} else {
			$rankDifference = $rankRight - $rankLeft;
		}
		$change['left'] = 0;
		$change['right'] = 0;
		if ($rankDifference <= 24) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 12; // expected
					$change['right'] -= 8; // expected
				} else {
					$change['right'] += 12; // unexpected
					$change['left'] -= 8; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 12; // expected
					$change['left'] -= 8; // expected
				} else {
					$change['left'] += 12; // unexpected
					$change['right'] -= 8; // unexpected
				}
			}
		} elseif ($rankDifference <= 49) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 11; // expected
					$change['right'] -= 7; // expected
				} else {
					$change['right'] += 14; // unexpected
					$change['left'] -= 9; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 11; // expected
					$change['left'] -= 7; // expected
				} else {
					$change['left'] += 14; // unexpected
					$change['right'] -= 9; // unexpected
				}
			}
		} elseif ($rankDifference <= 99) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 9; // expected
					$change['right'] -= 6; // expected
				} else {
					$change['right'] += 17; // unexpected
					$change['left'] -= 11; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 9; // expected
					$change['left'] -= 6; // expected
				} else {
					$change['left'] += 17; // unexpected
					$change['right'] -= 11; // unexpected
				}
			}
		} elseif ($rankDifference <= 149) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 8; // expected
					$change['right'] -= 5; // expected
				} else {
					$change['right'] += 21; // unexpected
					$change['left'] -= 14; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 8; // expected
					$change['left'] -= 5; // expected
				} else {
					$change['left'] += 21; // unexpected
					$change['right'] -= 14; // unexpected
				}
			}
		} elseif ($rankDifference <= 199) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 6; // expected
					$change['right'] -= 4; // expected
				} else {
					$change['right'] += 26; // unexpected
					$change['left'] -= 17; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 6; // expected
					$change['left'] -= 4; // expected
				} else {
					$change['left'] += 26; // unexpected
					$change['right'] -= 17; // unexpected
				}
			}
		} elseif ($rankDifference <= 299) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 5; // expected
					$change['right'] -= 3; // expected
				} else {
					$change['right'] += 33; // unexpected
					$change['left'] -= 22; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 5; // expected
					$change['left'] -= 3; // expected
				} else {
					$change['left'] += 33; // unexpected
					$change['right'] -= 22; // unexpected
				}
			}
		} elseif ($rankDifference <= 399) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 3; // expected
					$change['right'] -= 2; // expected
				} else {
					$change['right'] += 45; // unexpected
					$change['left'] -= 30; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 3; // expected
					$change['left'] -= 2; // expected
				} else {
					$change['left'] += 45; // unexpected
					$change['right'] -= 30; // unexpected
				}
			}
		} elseif ($rankDifference <= 499) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					$change['left'] += 2; // expected
					$change['right'] -= 1; // expected
				} else {
					$change['right'] += 60; // unexpected
					$change['left'] -= 40; // unexpected
				}
			} else {
				if ($winner == false) {
					$change['right'] += 2; // expected
					$change['left'] -= 1; // expected
				} else {
					$change['left'] += 60; // unexpected
					$change['right'] -= 40; // unexpected
				}
			}
		} elseif ($rankDifference >= 500) {
			if ($rankLeft > $rankRight) {
				if ($winner == true) {
					//$change['left'] += 0; // expected
					//$change['right'] -= 0; // expected
				} else {
					$change['right'] += 75; // unexpected
					$change['left'] -= 50; // unexpected
				}
			} else {
				if ($winner == false) {
					//$change['right'] += 0; // expected
					//$change['left'] -= 0; // expected
				} else {
					$change['left'] += 75; // unexpected
					$change['right'] -= 50; // unexpected
				}
			}
		}
		return $change;
	}	
	
	/* Delete
	======================================================================== */

	/**
	 *
	 */
	public function deleteById($id)
	{	
	
		// are you tied to any fixtures?

		$sql = "	
			SELECT
				tt_encounter_part.id
			FROM
				tt_encounter_part
			WHERE
				tt_encounter_part.player_id
		";

		// handle possible array

		if (is_array($id)) {

			$sql .= " IN ( ";

			foreach ($id as $key) {

				$sql .= " '$id',";

			}

			// trim away last ','

			$sql = substr($sql, 0, -1);
			$sql .= ")";

		} else {

			$sql .= " = '$id' ";

		}

		$sth = $this->database->dbh->query($sql);

		if ($sth->rowCount()) {

			$this->session->set('feedback', 'Unable to delete player, they are involved with matches');

			return;
			
		}

		// sql baseplate

		$sql = "	
			DELETE FROM
				tt_player
			WHERE tt_player.id
		";

		// handle possible array

		if (is_array($id)) {

			$sql .= " IN ( ";

			foreach ($id as $key) {

				$sql .= " '$id',";

			}

			// trim away last ','

			$sql = substr($sql, 0, -1);
			$sql .= ")";

		} else {

			$sql .= " = '$id' ";

		}

		// query database and get rows into $this->data

		$sth = $this->database->dbh->query($sql);

		// feedback & return

		if ($sth->rowCount()) {

			$this->session->set('feedback', 'Player Deleted');

		}

	}


	/**
	 * update player record using post
	 * @param  array $post 
	 * @return bool        
	 */
	public function update() {
		$sth = $this->database->dbh->prepare("
			select 
				first_name
				, last_name
				, rank
				, team_id
			from tt_player
			where id = ?
		");				
		$sth->execute(array(
			$_GET['edit']
		));		
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$sth = $this->database->dbh->prepare("
			update tt_player set
				first_name = ?
				, last_name = ?
				, rank = ?
				, team_id = ?
			where
				id = ?
		");				
		$sth->execute(array(
			(array_key_exists('first_name', $_POST) ? $_POST['first_name'] : '')
			, (array_key_exists('last_name', $_POST) ? $_POST['last_name'] : '')
			, (array_key_exists('rank', $_POST) ? $_POST['rank'] : '')
			, (array_key_exists('team_id', $_POST) ? $_POST['team_id'] : '')
			, (array_key_exists('edit', $_GET) ? $_GET['edit'] : '')
		));		
		$this->session->set('feedback', 'Player ' . ucfirst($row['first_name']) . ' ' . ucfirst($row['last_name']) . ' updated');
		return true;
	}
}