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
class ttPlayer extends Model
{		

	public function create() {	

		// validation

		if (! $this->validatePost($_POST, array(
			'first_name'
			, 'last_name'
			, 'rank'
			, 'team_id'
		))) {

			$this->getObject('mainUser')->setFeedback('All required fields must be filled');

			return false;
			
		}
		
		// prepare

		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tt_player
				(first_name, last_name, rank, team_id)
			VALUES
				(:first_name, :last_name, :rank, :team_id)
		");				
		
		$sth->execute(array(
			':first_name' => $_POST['first_name']
			, ':last_name' => $_POST['last_name']
			, ':rank' => $_POST['rank']
			, ':team_id' => $_POST['team_id']
		));		

		// return

		if ($sth->rowCount()) {

			$this->getObject('mainUser')->setFeedback('Success! Player has been created');

			return true;
			
		} else {

			$this->getObject('mainUser')->setFeedback('Error Detected, Player has not been Created');

			return false;

		}

		
	}
	

	public function select()
	{	
	
		$sth = $this->database->dbh->query("	
			SELECT
				tt_player.id
				, tt_player.rank
				, concat(tt_player.first_name, ' ', tt_player.last_name) AS full_name
				, tt_team.name AS team_name
				, tt_division.name AS division_name
			FROM
				tt_player
			LEFT JOIN tt_team ON tt_player.team_id = tt_team.id
			LEFT JOIN tt_division ON tt_team.division_id = tt_division.id
			ORDER BY
				tt_division.id
				, tt_team.id
				, tt_player.rank DESC
		");
		
		$this->setDataStatement($sth);

	}	



	public function getById($id)
	{		

		echo 'getting player: ' . $id . ' <br>';

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



	public function selectById($id)
	{	

		// sql baseplate

		$sql = "	
			SELECT
				tt_player.id
				, tt_player.rank
				, concat(tt_player.first_name, ' ', tt_player.last_name) AS player_name
			FROM
				tt_player
		";

		// handle possible array

		if (is_array($id)) {

			$first = true;

			foreach ($id as $key) {

				if ($first)
					$sql .= " WHERE ";
				else
					$sql .= " OR ";

				$sql .= " tt_player.id = '$key' ";

				$first = false;
				
			}

		} else {

			$sql .= "WHERE tt_player.id = '$id'";

		}

		// query database and get rows into $this->data

		$sth = $this->database->dbh->query($sql);
		$this->setDataStatement($sth);

	}	


	/**
	 * all data required to display the merit table
	 * player name, team name, team guid, player rank, sets won, sets played
	 * must exclude matches which have no opponent
	 */
	public function selectByTeam($teamId)
	{	

		$sth = $this->database->dbh->query("	
			SELECT
				tt_player.id AS player_id
				, concat(tt_player.first_name, ' ', tt_player.last_name) AS player_name
			FROM
				tt_player
			LEFT JOIN
				tt_team ON tt_player.team_id = tt_team.id
			WHERE
				tt_team.id = '$teamId'
			GROUP BY
				tt_player.id
			ORDER BY
				tt_player.rank DESC
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->data[$row['player_id']] = $row;
	
		}	

	}	


	/**
	 * all data required to display the merit table
	 * player name, team name, team guid, player rank, sets won, sets played
	 * must exclude matches which have no opponent
	 */
	public function selectMerit($division_id)
	{	

		$sth = $this->database->dbh->query("	

			SELECT
				tt_player.id
				, concat(tt_player.first_name, ' ', tt_player.last_name) AS full_name
				, tt_team.name as team_name
				, SUM(tt_encounter_part.player_score) AS total_sets_won

			FROM tt_player

			LEFT JOIN tt_encounter_part ON tt_encounter_part
			.player_id = tt_player.id

			LEFT JOIN tt_team ON tt_team.id = tt_player.team_id

			WHERE tt_team.division_id = '1'
			GROUP BY tt_player.id

		");

		return;

/*
			SELECT
				tt_player.id AS player_id
				, tt_player.rank AS player_rank
				, tt_player.first_name AS player_first_name
				, tt_player.last_name AS player_last_name
				, tt_team.name AS team_name
				, (SUM(tt_encounter.home_player_score) + SUM(tt_encounter.away_player_score)) AS total_played
			FROM
				tt_player
			LEFT JOIN
				tt_team ON tt_player.team_id = tt_team.id
			LEFT JOIN
				tt_division ON tt_team.division_id = tt_division.id
			LEFT JOIN
				tt_encounter ON tt_encounter.home_player_id = tt_player.id
				OR tt_encounter.away_player_id = tt_player.id
			WHERE
				tt_division.id = '1'
			AND (
				SELECT
					(SUM(tt_encounter.home_player_score) + SUM(tt_encounter.away_player_score)) 
				FROM
					student_details 
				WHERE subject= 'Science'
				) IS NOT NULL

			GROUP BY
				tt_player.id
			ORDER BY
				total_played DESC
 */


	}	


	/**
	 * updates a players rank using arrays provided
	 * @param  array $playerLeft  
	 * @param  array $playerRight 
	 * @param  array $rankChanges left and right rank changes
	 * @return null              
	 */
	public function updateRank($playerLeft, $playerRight, $rankChanges) {

		// update player ranks

		$playerLeft['new_rank'] = $playerLeft['rank'] + $rankChanges['left'];
		$playerRight['new_rank'] = $playerRight['rank'] + $rankChanges['right'];

		// set new player ranks

		$sth = $this->database->dbh->query("
			UPDATE
				tt_player
			SET 
				rank = '{$playerLeft['new_rank']}'
			WHERE
				id = '{$playerLeft['id']}'
		");	

		$sth = $this->database->dbh->query("
			UPDATE
				tt_player
			SET 
				rank = '{$playerRight['new_rank']}'
			WHERE
				id = '{$playerRight['id']}'
		");	

		return;

	}	
	

	/**
	 * takes player arrays and calculates player ranking changes, but does not 
	 * apply them
	 * @param  array $playerLeft  
	 * @param  array $playerRight 
	 * @return array              with player ranking changes
	 */
	public function rankDifference($playerLeft, $playerRight) {
	
		// find rank difference

		if ($playerLeft['id'] && $playerRight['id']) {

			if ($playerLeft['rank'] > $playerRight['rank'])

				$rankDifference = $playerLeft['rank'] - $playerRight['rank'];

			else

				$rankDifference = $playerRight['rank'] - $playerLeft['rank'];

		}

		// who won?

		if ($playerLeft['score'] >= 3)
			$winner = true;
		else
			$winner = false;

		// calculate rank change

		$playerLeft['rank_change'] = 0;
		$playerRight['rank_change'] = 0;

		if ($rankDifference <= 24) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 12; // expected
					$playerRight['rank_change'] -= 8; // expected
				} else {
					$playerRight['rank_change'] += 12; // unexpected
					$playerLeft['rank_change'] -= 8; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 12; // expected
					$playerLeft['rank_change'] -= 8; // expected
				} else {
					$playerLeft['rank_change'] += 12; // unexpected
					$playerRight['rank_change'] -= 8; // unexpected
				}
			}
		} elseif ($rankDifference <= 49) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 11; // expected
					$playerRight['rank_change'] -= 7; // expected
				} else {
					$playerRight['rank_change'] += 14; // unexpected
					$playerLeft['rank_change'] -= 9; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 11; // expected
					$playerLeft['rank_change'] -= 7; // expected
				} else {
					$playerLeft['rank_change'] += 14; // unexpected
					$playerRight['rank_change'] -= 9; // unexpected
				}
			}
		} elseif ($rankDifference <= 99) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 9; // expected
					$playerRight['rank_change'] -= 6; // expected
				} else {
					$playerRight['rank_change'] += 17; // unexpected
					$playerLeft['rank_change'] -= 11; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 9; // expected
					$playerLeft['rank_change'] -= 6; // expected
				} else {
					$playerLeft['rank_change'] += 17; // unexpected
					$playerRight['rank_change'] -= 11; // unexpected
				}
			}
		} elseif ($rankDifference <= 149) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 8; // expected
					$playerRight['rank_change'] -= 5; // expected
				} else {
					$playerRight['rank_change'] += 21; // unexpected
					$playerLeft['rank_change'] -= 14; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 8; // expected
					$playerLeft['rank_change'] -= 5; // expected
				} else {
					$playerLeft['rank_change'] += 21; // unexpected
					$playerRight['rank_change'] -= 14; // unexpected
				}
			}
		} elseif ($rankDifference <= 199) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 6; // expected
					$playerRight['rank_change'] -= 4; // expected
				} else {
					$playerRight['rank_change'] += 26; // unexpected
					$playerLeft['rank_change'] -= 17; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 6; // expected
					$playerLeft['rank_change'] -= 4; // expected
				} else {
					$playerLeft['rank_change'] += 26; // unexpected
					$playerRight['rank_change'] -= 17; // unexpected
				}
			}
		} elseif ($rankDifference <= 299) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 5; // expected
					$playerRight['rank_change'] -= 3; // expected
				} else {
					$playerRight['rank_change'] += 33; // unexpected
					$playerLeft['rank_change'] -= 22; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 5; // expected
					$playerLeft['rank_change'] -= 3; // expected
				} else {
					$playerLeft['rank_change'] += 33; // unexpected
					$playerRight['rank_change'] -= 22; // unexpected
				}
			}
		} elseif ($rankDifference <= 399) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 3; // expected
					$playerRight['rank_change'] -= 2; // expected
				} else {
					$playerRight['rank_change'] += 45; // unexpected
					$playerLeft['rank_change'] -= 30; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 3; // expected
					$playerLeft['rank_change'] -= 2; // expected
				} else {
					$playerLeft['rank_change'] += 45; // unexpected
					$playerRight['rank_change'] -= 30; // unexpected
				}
			}
		} elseif ($rankDifference <= 499) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					$playerLeft['rank_change'] += 2; // expected
					$playerRight['rank_change'] -= 1; // expected
				} else {
					$playerRight['rank_change'] += 60; // unexpected
					$playerLeft['rank_change'] -= 40; // unexpected
				}
			} else {
				if ($winner == false) {
					$playerRight['rank_change'] += 2; // expected
					$playerLeft['rank_change'] -= 1; // expected
				} else {
					$playerLeft['rank_change'] += 60; // unexpected
					$playerRight['rank_change'] -= 40; // unexpected
				}
			}
		} elseif ($rankDifference >= 500) {
			if ($playerLeft['rank'] > $playerRight['rank']) {
				if ($winner == true) {
					//$playerLeft['rank_change'] += 0; // expected
					//$playerRight['rank_change'] -= 0; // expected
				} else {
					$playerRight['rank_change'] += 75; // unexpected
					$playerLeft['rank_change'] -= 50; // unexpected
				}
			} else {
				if ($winner == false) {
					//$playerRight['rank_change'] += 0; // expected
					//$playerLeft['rank_change'] -= 0; // expected
				} else {
					$playerLeft['rank_change'] += 75; // unexpected
					$playerRight['rank_change'] -= 50; // unexpected
				}
			}
		}

		$rankChanges['left'] = $playerLeft['rank_change'];
		$rankChanges['right'] = $playerRight['rank_change'];

		return $rankChanges;
	
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

			$this->getObject('mainUser')->setFeedback('Unable to delete player, they are involved with matches');

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

			$this->getObject('mainUser')->setFeedback('Player Deleted Successfully');

		} else {

			$this->getObject('mainUser')->setFeedback('Error occurred, player not deleted');

		}

	}

}