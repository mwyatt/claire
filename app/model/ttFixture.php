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

	public static $encounterStructure = array(
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

		return self::$encounterStructure;

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

		$sth = $this->database->dbh->query("	
			SELECT
				tt_fixture.id
				, tt_fixture.team_left_id
				, tt_fixture.team_right_id
				, tt_fixture.date_fulfilled
			FROM
				tt_fixture
			WHERE
				tt_fixture.team_left_id = {$_POST['team']['left']}
				AND
				tt_fixture.team_right_id = {$_POST['team']['right']}
		");

		// check for matching fixture

		if ($row = $sth->fetch(PDO::FETCH_ASSOC))
			$fixtureId = $row['id'];
		else
			return false;

		// check for unfilled fixture

		if ($row['date_fulfilled'])
			return false;

		// player

		$playerIds = array_merge($_POST['player']['left'], $_POST['player']['right']);
		$ttPlayer = new ttPlayer($this->database, $this->config);
		$ttPlayer->selectById($playerIds);

		$encounterStructure = $this->getEncounterParts();

		// loop

		echo '<pre>';

		foreach ($_POST['encounter'] as $key => $score) {

			$key = $key - 1;

			// doubles?

			if ($key == 5) {

				$doubles = true;

				$playerLeft['name'] = 'doubles';
				$playerRight['name'] = 'doubles';

			} else {

				$doubles = false;

				$playerLeft = $ttPlayer->getById(
					$_POST['player']['left'][$encounterStructure['left'][$key]]
				);


				$playerRight = $ttPlayer->getById(
					$_POST['player']['right'][$encounterStructure['right'][$key]]
				);

				$playerRight['score'] = $score['right'];

			}

			$playerLeft['fixture_id'] = $fixtureId;
			$playerRight['fixture_id'] = $fixtureId;
			$playerLeft['score'] = $score['left'];
			$playerRight['score'] = $score['right'];

			$encounterParts = $ttPlayer->rankDifference($playerLeft, $playerRight);

			// create encounter
			
			$sth = $this->database->dbh->prepare("
				INSERT INTO
					tt_encounter
					(part_left_id, part_right_id, fixture_id)
				VALUES
					(:part_left_id, :part_right_id, :fixture_id)
			");				
			
			$sth->execute(array(
				':part_left_id' => $encounterParts['left']
				, ':part_right_id' => $encounterParts['left']
				, ':fixture_id' => $fixtureId
			));	
						
			// create encounter summary report

			echo '<pre>';
			print_r($playerLeft);
			print_r($playerRight);
			echo '</pre>';

			echo '<hr>';

		}

		echo '</pre>';


		// update fixture
		
		$sth = $this->database->dbh->query("
			UPDATE
				tt_fixture
			SET 
				date_fulfilled = NOW()
			WHERE
				id = '$fixtureId'
		");				



		exit;

	}	

	
	/* Delete
	========================================================================= */
	
	// reset method
	
	
	public function updateRank($homeRankChange, $awayRankChange) {
	
		echo $homeRankChange;
		echo $awayRankChange;
	
	}
	
}