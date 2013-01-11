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
		
		$this->setDataStatement($sth);

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
	public function readById($id)
	{	

		if (! $this->validateInt($id))
			return false;

		// sql baseplate

		$sql = "	
			select
				tt_player.id
				, tt_player.rank
				, tt_player.first_name
				, tt_player.last_name
				, concat(tt_player.first_name, ' ', tt_player.last_name) as full_name
				, tt_team.id as team_id
				, tt_division.id as division_id
			from
				tt_player
			left join tt_team on tt_player.team_id = tt_team.id
			left join tt_division on tt_division.id = tt_team.division_id
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

		// handle results

		$sth = $this->database->dbh->query($sql);

		if ($this->setDataStatement($sth))
			return $this->getData();
		else
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

			from
				tt_player

			left join
				tt_team on tt_player.team_id = tt_team.id

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

		if ($this->setDataStatement($sth))

			return true;

		else

			return false;
		
	}	


	/**
	 * read merit data from tt_encounter_part
	 * @param  int $division_id 
	 * @return bool              
	 */
	public function readMerit($division_id)
	{	

		$sth = $this->database->dbh->query("	
			select
				p.id
				, concat(p.first_name, ' ', p.last_name) as full_name
				, t.name as team
				, sum(case when ep2.player_id = p.id then ep2.player_score else NULL end) as won
				, sum(ep2.player_score) as played
			from tt_player as p
			left join tt_team as t on t.id = p.team_id
			left join tt_encounter_part as ep on ep.player_id = p.id
			left join tt_encounter as enc on enc.part_left_id = ep.id or enc.part_right_id = ep.id
			left join tt_encounter_part as ep2 on ep2.id = enc.part_left_id or ep2.id = enc.part_right_id
			where t.division_id = '1'
			group by p.id
		");

		$this->setDataStatement($sth);

		foreach ($this->getData() as $key => $row) {
			
			$this->data[$key]['average'] = $this->calcAverage($this->data[$key]['won'], $this->data[$key]['played']) . '&#37;';

		}

		return $this;

	}	


	/**
	 * calculates the average 0-100
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

	/**
	 * updates a players rank using arrays provided
	 * @param  array $playerLeft  
	 * @param  array $playerRight 
	 * @param  array $rankChanges left and right rank changes
	 * @return null              
	 */
	public function updateRank($playerId, $rankChange) {

		// get current rank

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

		// update rank

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
	

	/**
	 * takes player arrays and calculates player ranking changes, but does not 
	 * apply them
	 * @param  array $playerLeft  
	 * @param  array $playerRight 
	 * @return array              with player ranking changes
	 */
	public function rankDifference($encounter) {

		// find rank difference

		if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank'])

			$rankDifference = $encounter['left']['player']['rank'] - $encounter['right']['player']['rank'];

		else

			$rankDifference = $encounter['right']['player']['rank'] - $encounter['left']['player']['rank'];


		// who won?

		if ($encounter['left']['score'] >= 3)
			$winner = true;
		else
			$winner = false;

		// calculate rank change

		$encounter['left']['rank_change'] = 0;
		$encounter['right']['rank_change'] = 0;

		if ($rankDifference <= 24) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 12; // expected
					$encounter['right']['rank_change'] -= 8; // expected
				} else {
					$encounter['right']['rank_change'] += 12; // unexpected
					$encounter['left']['rank_change'] -= 8; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 12; // expected
					$encounter['left']['rank_change'] -= 8; // expected
				} else {
					$encounter['left']['rank_change'] += 12; // unexpected
					$encounter['right']['rank_change'] -= 8; // unexpected
				}
			}
		} elseif ($rankDifference <= 49) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 11; // expected
					$encounter['right']['rank_change'] -= 7; // expected
				} else {
					$encounter['right']['rank_change'] += 14; // unexpected
					$encounter['left']['rank_change'] -= 9; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 11; // expected
					$encounter['left']['rank_change'] -= 7; // expected
				} else {
					$encounter['left']['rank_change'] += 14; // unexpected
					$encounter['right']['rank_change'] -= 9; // unexpected
				}
			}
		} elseif ($rankDifference <= 99) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 9; // expected
					$encounter['right']['rank_change'] -= 6; // expected
				} else {
					$encounter['right']['rank_change'] += 17; // unexpected
					$encounter['left']['rank_change'] -= 11; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 9; // expected
					$encounter['left']['rank_change'] -= 6; // expected
				} else {
					$encounter['left']['rank_change'] += 17; // unexpected
					$encounter['right']['rank_change'] -= 11; // unexpected
				}
			}
		} elseif ($rankDifference <= 149) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 8; // expected
					$encounter['right']['rank_change'] -= 5; // expected
				} else {
					$encounter['right']['rank_change'] += 21; // unexpected
					$encounter['left']['rank_change'] -= 14; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 8; // expected
					$encounter['left']['rank_change'] -= 5; // expected
				} else {
					$encounter['left']['rank_change'] += 21; // unexpected
					$encounter['right']['rank_change'] -= 14; // unexpected
				}
			}
		} elseif ($rankDifference <= 199) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 6; // expected
					$encounter['right']['rank_change'] -= 4; // expected
				} else {
					$encounter['right']['rank_change'] += 26; // unexpected
					$encounter['left']['rank_change'] -= 17; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 6; // expected
					$encounter['left']['rank_change'] -= 4; // expected
				} else {
					$encounter['left']['rank_change'] += 26; // unexpected
					$encounter['right']['rank_change'] -= 17; // unexpected
				}
			}
		} elseif ($rankDifference <= 299) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 5; // expected
					$encounter['right']['rank_change'] -= 3; // expected
				} else {
					$encounter['right']['rank_change'] += 33; // unexpected
					$encounter['left']['rank_change'] -= 22; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 5; // expected
					$encounter['left']['rank_change'] -= 3; // expected
				} else {
					$encounter['left']['rank_change'] += 33; // unexpected
					$encounter['right']['rank_change'] -= 22; // unexpected
				}
			}
		} elseif ($rankDifference <= 399) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 3; // expected
					$encounter['right']['rank_change'] -= 2; // expected
				} else {
					$encounter['right']['rank_change'] += 45; // unexpected
					$encounter['left']['rank_change'] -= 30; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 3; // expected
					$encounter['left']['rank_change'] -= 2; // expected
				} else {
					$encounter['left']['rank_change'] += 45; // unexpected
					$encounter['right']['rank_change'] -= 30; // unexpected
				}
			}
		} elseif ($rankDifference <= 499) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					$encounter['left']['rank_change'] += 2; // expected
					$encounter['right']['rank_change'] -= 1; // expected
				} else {
					$encounter['right']['rank_change'] += 60; // unexpected
					$encounter['left']['rank_change'] -= 40; // unexpected
				}
			} else {
				if ($winner == false) {
					$encounter['right']['rank_change'] += 2; // expected
					$encounter['left']['rank_change'] -= 1; // expected
				} else {
					$encounter['left']['rank_change'] += 60; // unexpected
					$encounter['right']['rank_change'] -= 40; // unexpected
				}
			}
		} elseif ($rankDifference >= 500) {
			if ($encounter['left']['player']['rank'] > $encounter['right']['player']['rank']) {
				if ($winner == true) {
					//$encounter['left']['rank_change'] += 0; // expected
					//$encounter['right']['rank_change'] -= 0; // expected
				} else {
					$encounter['right']['rank_change'] += 75; // unexpected
					$encounter['left']['rank_change'] -= 50; // unexpected
				}
			} else {
				if ($winner == false) {
					//$encounter['right']['rank_change'] += 0; // expected
					//$encounter['left']['rank_change'] -= 0; // expected
				} else {
					$encounter['left']['rank_change'] += 75; // unexpected
					$encounter['right']['rank_change'] -= 50; // unexpected
				}
			}
		}

		return $encounter;
	
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

			$this->getObject('Session')->set('feedback', array('error', 'Unable to delete player, they are involved with matches'));

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

			$this->getObject('Session')->set('feedback', array('success', 'Player Deleted'));

		}

	}


	/**
	 * update player record using post
	 * @param  array $_POST 
	 * @return bool        
	 */
	public function update($_POST) {

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

		$sth = $this->database->dbh->prepare("
			update tt_player
			set
				first_name = ?
				, last_name = ?
				, rank = ?
				, team_id = ?
			where id = '{$_GET['update']}'
		");	

		$sth->execute(array(
			$_POST['first_name']
			, $_POST['last_name']
			, $_POST['rank']
			, $_POST['team_id']
		));		

		if ($sth->rowCount()) {

			$this->getObject('mainUser')->setFeedback('Player Successfully Updated');

			return true;
			
		}

		return false;

	}

}