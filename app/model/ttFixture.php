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
class Model_Ttfixture extends Model
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
	}
	
	
	/* Read
	========================================================================= */


	/**
	 * return $encounterParts for output on scoresheet
	 */
	public function getEncounterStructure() {

		return self::$encounterStructure;

	}

	
	/**
	 * selects all fixtures
	 * @return null 
	 */
	public function read() {	
		$sth = $this->database->dbh->query("	
			select
				tt_fixture.id
				, tt_fixture.date_fulfilled
				, team_left.name as team_left_name
				, team_right.name as team_right_name
				, sum(encounter_part_left.player_score) as score_left
				, sum(encounter_part_right.player_score) as score_right
			from tt_fixture
			left join tt_team as team_left on team_left.id = tt_fixture.team_left_id
			left join tt_team as team_right on team_right.id = tt_fixture.team_right_id
			left join tt_encounter on tt_encounter.fixture_id = tt_fixture.id
			left join tt_encounter_part as encounter_part_left on encounter_part_left.id = tt_encounter.part_left_id
			left join tt_encounter_part as encounter_part_right on encounter_part_right.id = tt_encounter.part_right_id
			group by tt_fixture.id
		");
		if ($sth->rowCount()) {
			$this->data = $sth->fetchAll(PDO::FETCH_ASSOC);
		}
		return;
	}	


	/**
	 * selects a single fixture from the database
	 * @param  integer $fixtureId 
	 * @return null            
	 */
	public function readSingle($fixtureId)
	{	
	
		$database->dbh->prepare("	

			select
				tt_encounter_row.id
				, case
					when tt_player_left.id = null
					then doubles
					else concat(tt_player_left.first_name, ' ', tt_player_left.last_name) 
					end
					as player_left_full_name
				, tt_encounter_row.player_left_score
				, tt_encounter_row.player_left_rank_change
				
				, concat(tt_player_right.first_name, ' ', tt_player_right.last_name) as player_right_full_name
				, tt_encounter_row.player_right_score
				, tt_encounter_row.player_right_rank_change

			from tt_encounter_row

			left join tt_player as tt_player_left on tt_player_left.id = tt_encounter_row.player_left_id
			
			left join tt_player as tt_player_right on tt_player_right.id = tt_encounter_row.player_right_id

			where tt_encounter_row.fixture_id = :fixture_id

		");

		$sth->execute(array(
			':fixture_id' => $fixtureId
		));

		$this->setDataStatement($sth);

	}	

	
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
	 * @param  array $post 
	 * @return true || false
	 */
	public function fulfill($post) {

		// validation

		if (! $this->validatePost($post, array(
			'division_id'
		))) {

			$this->getObject('mainUser')->setFeedback('Please fill all required fields');

			return false;
			
		}

		foreach ($post['encounter'] as $encounter) {
			foreach ($encounter as $side) {
				if ($side === false) {
					$this->getObject('mainUser')->setFeedback('Please fill all scores');
						return false;
				}
			}
		}

		// find fixture

		$sth = $this->database->dbh->prepare("	

			select
				f.id
				, f.team_left_id
				, f.team_right_id
				, f.date_fulfilled

			from
				tt_fixture as f

			where
				f.team_left_id = :team_left_id and f.team_right_id = :team_right_id

			group by
				f.id

		");

		$sth->execute(array(
			':team_left_id' => $post['team']['left']
			, ':team_right_id' => $post['team']['right']
		));

		// obtain fixture id

		if ($fixture = $sth->fetch(PDO::FETCH_ASSOC)) {

			// has it been filled yet?

			if ($fixture['date_fulfilled']) {

				$this->getObject('mainUser')->setFeedback(array('error', 'This fixture has already been filled on ' . date('D jS F Y', $fixture['date_fulfilled'])));

				return;

			}

		} else {

			// fixture does not exist

			$this->getObject('mainUser')->setFeedback(array('error', 'This fixture does not exist'));

			return;

		}

		// get 6 players

		$playerIds = array_merge($post['player']['left'], $post['player']['right']);
		$ttPlayer = new ttPlayer($this->database, $this->config);
		$ttPlayer->readById($playerIds);

		// prepare statements

		$sthEncounterPart = $this->database->dbh->prepare("
			
			insert into
				tt_encounter_part
				(player_id, player_score, player_rank_change, status)

			values
				(:player_id, :player_score, :player_rank_change, :status)

		");				
		
		$sthEncounter = $this->database->dbh->prepare("

			insert into
				tt_encounter
				(part_left_id, part_right_id, fixture_id)

			values
				(:part_left_id, :part_right_id, :fixture_id)

		");	


		// the loop
		// builds $encounters
		
		// get encounter structure
		$encounterStructure = $this->getEncounterStructure();

		foreach ($post['encounter'] as $key => $score) {

			$doubles = false;
			$exclude = false;

			// encounter || doubles

			if ($key != 5) {

				// fill array with player info or false

				$encounters[$key]['left']['player'] = $ttPlayer->getById($post['player']['left'][$encounterStructure['left'][$key]]);
				$encounters[$key]['right']['player'] = $ttPlayer->getById($post['player']['right'][$encounterStructure['right'][$key]]);

				// find absent player

				if (! $encounters[$key]['left']['player'] || ! $encounters[$key]['right']['player'])
					$exclude = true;

				// find exclude tick

				if (array_key_exists('exclude', $score))
					$exclude = true;

			} else {

				// doubles

				$encounters[$key]['left']['player'] = false;
				$encounters[$key]['right']['player'] = false;
				$doubles = true;

			}

			// set scores

			$encounters[$key]['left']['score'] = $score['left'];
			$encounters[$key]['right']['score'] = $score['right'];

			// helper: absent player score setter

			if ($exclude) {
				
				if (! $encounters[$key]['left']['player']) {
					$encounters[$key]['left']['score'] = 0;
					$encounters[$key]['right']['score'] = 3;
				} else {
					$encounters[$key]['left']['score'] = 3;
					$encounters[$key]['right']['score'] = 0;
				}

			}

			// set encounter parts, decide if is absent or doubles
			// else set rank difference

			if ($exclude) {

				$sthEncounterPart->execute(array(
					':player_id' => $encounters[$key]['left']['player']['id']
					, ':player_score' => $encounters[$key]['left']['score']
					, ':player_rank_change' => '0'
					, ':status' => 'exclude'
				));

				$encounterPartIds['left'] = $this->database->dbh->lastInsertId();

				$sthEncounterPart->execute(array(
					':player_id' => $encounters[$key]['right']['player']['id']
					, ':player_score' => $encounters[$key]['right']['score']
					, ':player_rank_change' => '0'
					, ':status' => 'exclude'
				));		

				$encounterPartIds['right'] = $this->database->dbh->lastInsertId();

			} elseif ($doubles) {

				$sthEncounterPart->execute(array(
					':player_id' => false
					, ':player_score' => $encounters[$key]['left']['score']
					, ':player_rank_change' => false
					, ':status' => 'doubles'
				));		

				$encounterPartIds['left'] = $this->database->dbh->lastInsertId();

				$sthEncounterPart->execute(array(
					':player_id' => false
					, ':player_score' => $encounters[$key]['right']['score']
					, ':player_rank_change' => false
					, ':status' => 'doubles'
				));						

				$encounterPartIds['right'] = $this->database->dbh->lastInsertId();

			} else {

				$encounters[$key] = $ttPlayer->rankDifference($encounters[$key]);

				// update player ranks

				$ttPlayer->updateRank($encounters[$key]['left']['player']['id'], $encounters[$key]['left']['rank_change']);
				$ttPlayer->updateRank($encounters[$key]['right']['player']['id'], $encounters[$key]['right']['rank_change']);


				$sthEncounterPart->execute(array(
					':player_id' => $encounters[$key]['left']['player']['id']
					, ':player_score' => $encounters[$key]['left']['score']
					, ':player_rank_change' => $encounters[$key]['left']['rank_change']
					, ':status' => false
				));		

				$encounterPartIds['left'] = $this->database->dbh->lastInsertId();
				
				$sthEncounterPart->execute(array(
					':player_id' => $encounters[$key]['right']['player']['id']
					, ':player_score' => $encounters[$key]['right']['score']
					, ':player_rank_change' => $encounters[$key]['right']['rank_change']
					, ':status' => false
				));	
				
				$encounterPartIds['right'] = $this->database->dbh->lastInsertId();

			}

			// set encounter

			$sthEncounter->execute(array(
				':part_left_id' => $encounterPartIds['left']
				, ':part_right_id' => $encounterPartIds['right']
				, ':fixture_id' => $fixture['id']
			));	

		}

		// update the fixture

		$sthFixture = $this->database->dbh->prepare("

			update
				tt_fixture

			set 
				date_fulfilled = :date_fulfilled

			where
				id = {$fixture['id']}

		");

		$sthFixture->execute(array(
			':date_fulfilled' => time()
		));	

		// feedback

		$this->getObject('Session')->set('fixture_overview', $encounters);
		$this->getObject('mainUser')->setFeedback(array('success', 'Fixture Fulfilled Successfully'));

		return;

	}	

	
	/* Delete
	========================================================================= */
	
	// reset method
	
	
	public function updateRank($homeRankChange, $awayRankChange) {
	
		echo $homeRankChange;
		echo $awayRankChange;
	
	}


	public function readSingleResult($fixtureId) {

		$sth = $this->database->dbh->prepare("	
			select
				concat(player_left.first_name, ' ', player_left.last_name) as player_left_full_name
				, concat(player_right.first_name, ' ', player_right.last_name) as player_right_full_name
				, tt_encounter_result.left_id as player_left_id
				, tt_encounter_result.right_id as player_right_id
				, tt_encounter_result.left_rank_change
				, tt_encounter_result.right_rank_change
				, tt_encounter_result.left_score as player_left_score
				, tt_encounter_result.right_score as player_right_score
				, team_left.id as team_left_id
				, team_right.id as team_right_id
				, team_left.name as team_left_name
				, team_right.name as team_right_name
				, tt_fixture_result.left_score as team_left_score
				, tt_fixture_result.right_score as team_right_score
				, tt_encounter_result.status
				, tt_fixture.date_fulfilled		

			from tt_encounter_result

			left join tt_player as player_left on player_left.id = tt_encounter_result.left_id

			left join tt_player as player_right on player_right.id = tt_encounter_result.right_id

			left join tt_fixture on tt_fixture.id = tt_encounter_result.fixture_id

			left join tt_fixture_result on tt_fixture_result.fixture_id = tt_encounter_result.fixture_id

			left join tt_team as team_left on team_left.id = tt_fixture.team_left_id

			left join tt_team as team_right on team_right.id = tt_fixture.team_right_id

			where tt_encounter_result.fixture_id = :fixtureId

			group by tt_encounter_result.encounter_id

			order by tt_encounter_result.encounter_id
		");

		$sth->execute(array(':fixtureId' => $fixtureId));
		if (!$sth->rowCount()) return false;

		$ttPlayer = new ttPlayer($this->database, $this->config);
		$ttTeam = new ttTeam($this->database, $this->config);

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$row['player_left_guid'] = $ttPlayer->getGuid($row['player_left_full_name'], $row['player_left_id']);
			$row['player_right_guid'] = $ttPlayer->getGuid($row['player_right_full_name'], $row['player_right_id']);
			$row['team_left_guid'] = $ttTeam->getGuid($row['team_left_name'], $row['team_left_id']);
			$row['team_right_guid'] = $ttTeam->getGuid($row['team_right_name'], $row['team_right_id']);
			$this->data[] = $row;
		}

		return true;

	}

	public function readResult($divisionId) {

		$sth = $this->database->dbh->prepare("	
			select
				tt_fixture_result.fixture_id as id
				, team_left.name as team_left_name
				, tt_fixture_result.left_score
				, team_right.name as team_right_name
				, tt_fixture_result.right_score
				, tt_fixture.date_fulfilled

			from tt_fixture_result

			left join tt_team as team_left on team_left.id = tt_fixture_result.left_id

			left join tt_team as team_right on team_right.id = tt_fixture_result.right_id

			left join tt_division on team_left.division_id = tt_division.id

			left join tt_fixture on tt_fixture.id = tt_fixture_result.fixture_id

			where team_left.division_id = :division_id

			group by tt_fixture_result.fixture_id

			order by tt_fixture.date_fulfilled desc
		");

		$sth->execute(array(':division_id' => $divisionId));

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$row['guid'] = $this->getGuid($row);
			$this->data[] = $row;
		}

		return $this;

	}

	// public function getGuid($row) {
	// 	return $this->config->getUrl('base') . 'fixture/' . $this->urlFriendly($row['team_left_name']) . '-vs-' . $this->urlFriendly($row['team_right_name']) . '-' . $row['id'] . '/';
	// }


	
}
