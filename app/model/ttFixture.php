<?php

/**
 * ttFixture
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class ttFixture extends Model
{

	public static $encounterParts = array(
		'left' => array(1, 3, 2, 3, 1, 'doubles', 2, 3, 2, 1)
		, 'right' => array(2, 1, 3, 2, 3, 'doubles', 1, 3, 2, 1)
	);

	
	/* Create
	========================================================================= */
	
	/**
	 * generates each fixture seperated by division
	 * teams must not change division beyond this point
	 */
	public function generateAll() {
		
		$sth = $this->database->dbh->query("	
			SELECT
				tt_division.id as division_id
				, tt_team.id as team_id
			FROM
				tt_division				
			LEFT JOIN tt_team ON tt_division.id = tt_team.division_id
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->data[$row['division_id']][] = $row['team_id'];
	
		}						
				
		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tt_fixture
				(team_left_id, team_right_id)
			VALUES
				(:team_left_id, :team_right_id)
		");				
				
		// loop to set team vs team fixtures
		foreach ($this->data as $division) {
		
			foreach ($division as $key => $homeTeam) {
			
				foreach ($division as $key => $awayTeam) {
		
					if ($homeTeam !== $awayTeam) {
										
						$sth->execute(array(
							':team_left_id' => $homeTeam
							, ':team_right_id' => $awayTeam
						));					
					
					}
		
				}
			}
		
		}

		echo 'All Fixtures Generated';
		
	}
	
	
	/* Read
	========================================================================= */


	/**
	 * return $encounterParts for output on scoresheet
	 */
	public function getEncounterParts() {

		return self::$encounterParts;

	}

	
	/**
	 * 
	 */
	public function select()
	{	
	
		$sth = $this->database->dbh->query("	
			SELECT
				tt_division.id AS division_id
				, tt_team.id AS team_id
				, tt_team.name AS team_name
				, tt_player.id AS player_id
				, tt_player.first_name AS player_first_name
				, tt_player.last_name AS player_last_name
			FROM
				tt_division
			LEFT JOIN tt_team ON tt_team.division_id = tt_division.id
			LEFT JOIN tt_player ON tt_player.team_id = tt_team.id
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->data[$row['division_id']][$row['team_name']][$row['player_id']]['full_name'] = $row['player_first_name'] . ' ' . $row['player_last_name'];
	
		}	
		
		echo '<pre>';
		print_r ($this->data);
		echo '</pre>';		
		exit;


	}	
	
	/* Update
	========================================================================= */
	
	/**
	 * updates a fixture and fills scorecard information
	 * the objectives are:
	 * 		fill the encounter parts table with 2 rows
	 * 		update the encounter table with the 2 ids
	 * 		update the fixture date filled
	 *
	 * need to build some kind of array to store all the results information
	 * this way the tt_encounter table can be updated with correct id's
	 *
	 * build up array so then x vs x can be directly compared, needed for rank
	 * comparison and other things
	 *
	 * possible to have POST sent in as array for the encounter scores?
	 * 
	 * @param  array $_POST 
	 * @return true || false
	 */
	public function fulfill($_POST) {

		// generic validation

		if (! $_POST['team'] || ! $_POST['player'] || ! $_POST['encounter'])
				return false;

		// fixture

		$sthFixture = $this->database->dbh->query("	
			SELECT
				tt_fixture.id AS id
				, tt_fixture.team_left_id AS team_left_id
				, tt_fixture.team_right_id AS team_right_id
			FROM
				tt_fixture
			WHERE
				tt_fixture.team_left_id = {$_POST['team']['left']}
				AND
				tt_fixture.team_right_id = {$_POST['team']['right']}
		");

		if ($fixture = $sthFixture->fetch(PDO::FETCH_ASSOC))
			$fixtureId = $fixture['id'];
		else
			return false;

		// player

		$playerIds = array_merge($_POST['player']['left'], $_POST['player']['right']);

		$ttPlayer = new ttPlayer($this->database, $this->config);
		$ttPlayer->selectById($playerIds);

		



		echo '<pre>';
		print_r($playerIds);
		print_r($_POST);
		print_r($ttPlayer);
		echo '</pre>';
		exit;
		

/*
		$sthEncounter = $this->database->dbh->prepare("
			INSERT INTO
				tt_encounter
				(part_left_id, part_right_id, fixture_id)
			VALUES
				(:part_left_id, :part_right_id, '$fixtureId')
		");

		$sthEncounterPart = $this->database->dbh->prepare("
			INSERT INTO
				tt_encounter_part
				(player_id, player_score)
			VALUES
				(:player_id, :player_score)
		");

		foreach ($this->getEncounterParts() as $side => $parts) {

			$encounter = 1;

			foreach ($parts as $part) {

				$playerKey = 'player_' . $side . '_' . $part . '_id';
				$encounterKey = 'encounter_' . $part . '_' . $side;



				if (array_key_exists($playerKey, $_POST)) {

					if (array_key_exists($encounterKey, $_POST)) {

						$sthEncounterPart->execute(array(
							':player_id' => $_POST[$playerKey]
							, ':player_score' => $_POST[$encounterKey]
						));					

						$currentPartId = $this->database->dbh->lastInsertId();
						
						$encounters[$side][] = $currentPartId;

						


						$encounter ++;

					}

				} elseif ($part == 'doubles') {
					
					$playerKey = 0;
					$encounterKey = 'encounter_' . $part . '_' . $side;

					$sthEncounterPart->execute(array(
						':player_id' => $playerKey
						, ':player_score' => $_POST[$encounterKey]
					));					

					$encounter ++;

				}

			}

		}

		exit;
*/
	}	
 

/*$_POST['player_left_1_id']
$_POST['player_left_2_id']
$_POST['player_left_3_id']
$_POST['player_right_1_id']
$_POST['player_right_2_id']
$_POST['player_right_3_id']

$_POST['encounter_1_left']
$_POST['encounter_2_left']
$_POST['encounter_3_left']
$_POST['encounter_4_left']
$_POST['encounter_5_left']
$_POST['encounter_doubles_left']
$_POST['encounter_6_left']
$_POST['encounter_7_left']
$_POST['encounter_8_left']
$_POST['encounter_9_left']
$_POST['encounter_1_right']
$_POST['encounter_2_right']
$_POST['encounter_3_right']
$_POST['encounter_4_right']
$_POST['encounter_5_right']
$_POST['encounter_doubles_right']
$_POST['encounter_6_right']
$_POST['encounter_7_right']
$_POST['encounter_8_right']
$_POST['encounter_9_right']*/

	
	/* Delete
	========================================================================= */
	
	// reset method
	
	
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
	
}