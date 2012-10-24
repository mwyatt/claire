<?php

/**
 * ttPlayer
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


	/* Create
	======================================================================== */
	
	/**
	 * create a new record
	 */
	public function create($_POST) {	
		
		if ($this->validatePost($_POST, array('first_name', 'last_name', 'rank', 'team')) == false)
	
			return false;
		
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
			, ':team_id' => $_POST['team']
		));		

		return $sth->rowCount();
		
	}
	
	
	/* Read
	======================================================================== */

	/**
	 * must obtain all player information, with team name combined
	 */
	public function select()
	{	
	
		$sth = $this->database->dbh->query("	
			SELECT
				tt_player.id AS player_id
				, tt_player.rank AS player_rank
				, tt_player.first_name AS player_first_name
				, tt_player.last_name AS player_last_name
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
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->data[$row['player_id']] = array(
				'player_id' => $row['player_id']
				, 'player_name' => $row['player_first_name'] . ' ' . $row['player_last_name']
				, 'player_rank' => $row['player_rank']
				, 'team_name' => $row['team_name']
				, 'division_name' => $row['division_name']
			);
	
		}	

	}	


	public function selectById($id)
	{	

		// sql baseplate

		$sql = "	
			SELECT
				tt_player.id AS player_id
				, tt_player.rank AS player_rank
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
		");
		
//		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			// $this->data[$row['player_id']] = array(
			// 	'player_id' => $row['player_id']
			// 	, 'player_name' => $row['player_first_name'] . ' ' . $row['player_last_name']
			// 	, 'player_rank' => $row['player_rank']
			// 	, 'team_name' => $row['team_name']
			// 	, 'division_name' => $row['division_name']
			// );
	
//		}	

	}	

	
	/* Update
	======================================================================== */
	
	public function updateRank($homeRankChange, $awayRankChange) {
	
		echo $homeRankChange;
		echo $awayRankChange;
	
	}	
	
	/**
	 * finds out what ranking bracket the victory falls into and awards points
	 * the getWinner method returns true for home and false for away
	 * before you reach this function you must have obtained
	 * the rank difference
	 * home player id
	 * home player rank
	 * away player id
	 * away player rank
	 * you can obtain all of this via 1 select
	 */
	public function rankDifference() {
	
		$rankDifference = 23;
		
		switch ($rankDifference) {
		
			case $rankDifference <= 24:
			
				// whos rank is greatest?
				// is the win expected or unexpected?
			
				/*if ($this->getWinner())
					$this->updateRank(+12, -8);
				else
					$this->updateRank(+12, -8);
				break;*/
				
		}		
	
	/*
	function ttl_award_points( $rd, $hp_id, $hp, $hpr, $ap_id, $ap, $apr, $win ) {
		if ( $rd <= 24 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 12; // expected
					$apr -= 8; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 12; // unexpected
					$hpr -= 8; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 12; // expected
					$hpr -= 8; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 12; // unexpected
					$apr -= 8; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 49 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 11; // expected
					$apr -= 7; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 14; // unexpected
					$hpr -= 9; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 11; // expected
					$hpr -= 7; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 14; // unexpected
					$apr -= 9; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 99 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 9; // expected
					$apr -= 6; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 17; // unexpected
					$hpr -= 11; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 9; // expected
					$hpr -= 6; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 17; // unexpected
					$apr -= 11; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 149 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 8; // expected
					$apr -= 5; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 21; // unexpected
					$hpr -= 14; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 8; // expected
					$hpr -= 5; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 21; // unexpected
					$apr -= 14; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 199 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 6; // expected
					$apr -= 4; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 26; // unexpected
					$hpr -= 17; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 6; // expected
					$hpr -= 4; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 26; // unexpected
					$apr -= 17; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 299 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 5; // expected
					$apr -= 3; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 33; // unexpected
					$hpr -= 22; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 5; // expected
					$hpr -= 3; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 33; // unexpected
					$apr -= 22; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 399 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 3; // expected
					$apr -= 2; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 45; // unexpected
					$hpr -= 30; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 3; // expected
					$hpr -= 2; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 45; // unexpected
					$apr -= 30; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd <= 499 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					$hpr += 2; // expected
					$apr -= 1; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 60; // unexpected
					$hpr -= 40; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					$apr += 2; // expected
					$hpr -= 1; // expected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 60; // unexpected
					$apr -= 40; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		} elseif ( $rd >= 500 ) {
			if ( $hpr > $apr ) { // compare rank
				if ( $win == 'home' ) {
					//$hpr += 0; // expected
					//$apr -= 0; // expected
					//ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$apr += 75; // unexpected
					$hpr -= 50; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			} else {
				if ( $win == 'away' ) {
					//$apr += 0; // expected
					//$hpr -= 0; // expected
					//ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				} else {
					$hpr += 75; // unexpected
					$apr -= 50; // unexpected
					ttl_update_rank( $hp_id, $hp, $hpr, $ap_id, $ap, $apr );
				}
			}
		}
	}*/
	
	
	}	
	
	/* Delete
	======================================================================== */

	/**
	 *
	 */
	public function delete($id)
	{	
	
		$sth = $this->database->dbh->query("
			DELETE FROM
				tt_player
			WHERE
				id = '$id'		
		");
		
		return $sth->rowCount();
		
	}
	

}