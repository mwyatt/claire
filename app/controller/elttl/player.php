<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Player extends Controller_Archive
{


	public $player;


	public $personalEncounters;


	/**
	 * @return object 
	 */
	public function getPlayer() {
	    return $this->player;
	}
	
	
	/**
	 * @param object $player 
	 */
	public function setPlayer($player) {
	    $this->player = $player;
	    return $this;
	}


	/**
	 * @return array 
	 */
	public function getPersonalEncounters() {
	    return $this->personalEncounters;
	}
	
	
	/**
	 * @param array $personalEncounters 
	 */
	public function setPersonalEncounters($personalEncounters) {
	    $this->personalEncounters = $personalEncounters;
	    return $this;
	}


	public function run()
	{
		$this->readYear();

		// player/martin-wyatt/
		if ($this->url->getPathPart(1)) {
			$this->single();
		}
	}


	public function single()
	{

		// player
		$names = $this->url->getPathPart(1);
		$names = explode('-', $names);
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array(
				'name_first' => reset($names),
				'name_last' => end($names)
			)
		));
		if (! $player = $modelTennisPlayer->getDataFirst()) {
			$this->route('base');
		}
		$this->setPlayer($player);

		// team
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array(
				'id' => $player->getTeamId()
			)
		));
		$team = $modelTennisTeam->getDataFirst();

		// division
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read(array(
			'where' => array(
				'id' => $team->getDivisionId()
			)
		));

		// merit
		$this->getMeritStats();

		// team mates
		$modelTennisPlayer->read(array(
			'where' => array(
				'team_id' => $team->getId()
			)
		));
		$acquaintances = $modelTennisPlayer->getData();
	
		// personal encounters
		$personalEncounters = $this->getPersonalEncounters();
		$personalEncounters->orderByPropertyIntDesc('id');

		// fixtures played in
		$fixtureIds = $personalEncounters->getDataProperty('fixture_id');
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('id' => $fixtureIds)
		));
		$fixtures = $modelTennisFixture->getData();

		// players
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right')))
		));
		$modelTennisPlayer->keyByProperty('id');

		// teams
		$modelTennisTeam
			->read(array(
				'where' => array(
					'id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right'))
				)
			))
			->keyByProperty('id');
		$teams = $modelTennisTeam->getData();

		// all fixtures played in encounters
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $fixtureIds)
		));
		$modelTennisEncounter->convertToFixtureResults();
		$fixtureResults = $modelTennisEncounter->getData();

		// template
		$this->view
			->setMeta(array(		
				'title' => 'Player ' . $player->getNameFull()
			))
			->setObject('division', $modelTennisDivision->getDataFirst())
			->setObject('player', $player)
			->setObject('players', $modelTennisPlayer->getData())
			->setObject('team', $team)
			->setObject('teams', $teams)
			->setObject('acquaintances', $acquaintances)
			->setObject('fixtures', $fixtures)
			->setObject('fixtureResults', $fixtureResults)
			->setObject('encounters', $personalEncounters->getData())
			->getTemplate('player-single');
	}


	/**
	 * builds the merit table for one player specifically
	 * relys on the player object being set
	 * @return null 
	 */
	public function getMeritStats()
	{
		if (! $player = $this->getPlayer()) {
			return;
		}
		
		// encounters
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('player_id_left' => $player->getId())
		));
		$encounters = $modelTennisEncounter->getData();
		$modelTennisEncounter->read(array(
			'where' => array('player_id_right' => $player->getId())
		));
		$encounters = array_merge($encounters, $modelTennisEncounter->getData());
		$modelTennisEncounter->setData($encounters);
		$modelTennisEncounterCopy = new model_tennis_encounter($this);
		$modelTennisEncounterCopy->setData($encounters);
		$this->setPersonalEncounters($modelTennisEncounterCopy);

		// convert encounters to merit results
		$modelTennisEncounter
			->removeStatus()
			->convertToMerit()
			->orderByHighestAverage();

		// template
		$this->view
			->setObject('meritRows', $modelTennisEncounter->getData());
	}
}
