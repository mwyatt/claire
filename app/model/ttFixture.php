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
	 * selects all fixtures
	 * @return null 
	 */
	public function read()
	{	
	
		$sth = $this->database->dbh->query("	
			select
				tt_fixture.id
				, tt_fixture.date_fulfilled
				, team_left.name as team_left
				, team_right.name as team_right
				, sum(encounter_part_left.player_score) as left_score
				, sum(encounter_part_right.player_score) as right_score
			from tt_fixture
			left join tt_team as team_left on team_left.id = tt_fixture.team_left_id
			left join tt_team as team_right on team_right.id = tt_fixture.team_right_id
			left join tt_encounter on tt_encounter.fixture_id = tt_fixture.id
			left join tt_encounter_part as encounter_part_left on encounter_part_left.id = tt_encounter.part_left_id
			left join tt_encounter_part as encounter_part_right on encounter_part_right.id = tt_encounter.part_right_id
			group by tt_fixture.id
		");

		$this->setDataStatement($sth);

		echo '<pre>';
		print_r ($this);
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

		// validation

		if (! $this->validatePost($_POST, array(
			'team'
			, 'player'
			, 'encounter'
			, 'total'
		))) {

			$this->getObject('mainUser')->setFeedback('Please fill all required fields');

			return;
			
		}

		// find fixture

		$sth = $this->database->dbh->prepare("	

			select
				f.id
				, f.team_left_id
				, f.team_left_score
				, f.team_right_id
				, f.team_right_score
				, f.date_fulfilled

			from
				tt_fixture as f

			where
				f.team_left_id = :team_left_id and f.team_right_id = :team_right_id

			group by
				f.id

		");

		$sth->execute(array(
			':team_left_id' => $_POST['team']['left']
			, ':team_right_id' => $_POST['team']['right']
		));

		// obtain fixture id

		if ($fixture = $sth->fetch(PDO::FETCH_ASSOC)) {

			$fixtureId = $fixture['id'];

			// has it been filled yet?

			if ($fixture['date_fulfilled']) {

				$this->getObject('mainUser')->setFeedback('This fixture has already been filled on ' . $fixture['date_fulfilled']);

				return;

			}

		} else {

			$this->getObject('mainUser')->setFeedback('This fixture was not found, not good!');

			return;

		}

		// get players

		$playerIdGroup = array_merge($_POST['player']['left'], $_POST['player']['right']);
		$ttPlayer = new ttPlayer($this->database, $this->config);
		$ttPlayer->readById($playerIdGroup);

		// get encounter structure for use in the loop

		$encounterStructure = $this->getEncounterParts();

		// loop

		foreach ($_POST['encounter'] as $key => $score) {

			$key = $key - 1;
			$doubles = false;
			$noShow = false;

			// is this doubles?

			if ($key == 5) {

				$doubles = true;

				$playerLeft['id'] = 'd';
				$playerRight['id'] = 'd';

			} else {

				$playerLeft = $ttPlayer->getById(
					$_POST['player']['left'][$encounterStructure['left'][$key]]
				);

				$playerRight = $ttPlayer->getById(
					$_POST['player']['right'][$encounterStructure['right'][$key]]
				);
echo '<pre>';
print_r($playerLeft);
echo '</pre>';
exit;


$this->getObject('session')->set('form_fulfill', );


				// check for no show

				if (! $playerLeft) {
					$playerLeft['id'] = 0;
					$noShow = true;
				}

				if (! $playerRight) {
					$playerRight['id'] = 0;
					$noShow = true;
				}

			}

			$playerLeft['score'] = $score['left'];
			$playerRight['score'] = $score['right'];

			// calculate rank changes if this is not doubles or noshow

			if (! $noShow && ! $doubles) {

				$rankChanges = $ttPlayer->rankDifference($playerLeft, $playerRight);

				$ttPlayer->updateRank($playerLeft, $playerRight, $rankChanges);

			} else {

				$rankChanges['left'] = 0;
				$rankChanges['right'] = 0;

			}

			// add encounter parts

			$sth = $this->database->dbh->prepare("
				INSERT INTO
					tt_encounter_part
					(player_id, player_score, player_rank_change)
				VALUES
					(:player_id, :player_score, :player_rank_change)
			");				
			
			$sth->execute(array(
				':player_id' => $playerLeft['id']
				, ':player_score' => $playerLeft['score']
				, ':player_rank_change' => $rankChanges['left']
			));		

			$encounterPartsId['left'] = $this->database->dbh->lastInsertId();

			$sth->execute(array(
				':player_id' => $playerRight['id']
				, ':player_score' => $playerRight['score']
				, ':player_rank_change' => $rankChanges['right']
			));

			$encounterPartsId['right'] = $this->database->dbh->lastInsertId();

			// create encounter
			
			$sth = $this->database->dbh->prepare("
				INSERT INTO
					tt_encounter
					(part_left_id, part_right_id, fixture_id)
				VALUES
					(:part_left_id, :part_right_id, :fixture_id)
			");				
			
			$sth->execute(array(
				':part_left_id' => $encounterPartsId['left']
				, ':part_right_id' => $encounterPartsId['right']
				, ':fixture_id' => $fixtureId
			));	
						
			// create encounter summary report

			echo '<pre>';
			print_r($playerLeft);
			print_r($playerRight);
			echo '</pre>';

			echo '<hr>';

		}

		// update fixture
		
		$sth = $this->database->dbh->prepare("

			update
				tt_fixture

			set 
				date_fulfilled = now()
				, tt_fixture.team_left_score = :team_left_score
				, tt_fixture.team_right_score = :team_right_score


			where
				id = '$fixtureid'

		");				

		$this->getObject('mainUser')->setFeedback('Fixture Fulfilled Successfully');

		exit;
		// return;

	}	

	
	/* Delete
	========================================================================= */
	
	// reset method
	
	
	public function updateRank($homeRankChange, $awayRankChange) {
	
		echo $homeRankChange;
		echo $awayRankChange;
	
	}
	
}