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
		if ($this->getArchivePathPart(1)) {
			$this->single();
		}
	}


	public function single()
	{

		// player
		$names = $this->getArchivePathPart(1);
		$names = explode('-', $names);
		$className = $this->getArchiveClassName('model_tennis_player');
		$modelTennisPlayer = new $className($this);
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array(
				'name_first' => reset($names),
				'name_last' => end($names)
			)
		)));
		if (! $player = $modelTennisPlayer->getDataFirst()) {
			$this->redirect('base');
		}
		$this->setPlayer($player);

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array(
				'id' => $player->getTeamId()
			)
		)));
		$team = $modelTennisTeam->getDataFirst();

		// division
		$className = $this->getArchiveClassName('model_tennis_division');
		$modelTennisDivision = new $className($this);
		$modelTennisDivision->read($this->getArchiveWhere(array(
			'where' => array(
				'id' => $team->getDivisionId()
			)
		)));

		// merit
		$this->getMeritStats();

		// team mates
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array(
				'team_id' => $team->getId()
			)
		)));
		$acquaintances = $modelTennisPlayer->getData();
	
		// personal encounters
		$personalEncounters = $this->getPersonalEncounters();
		$personalEncounters->orderByPropertyIntDesc('id');

		// fixtures played in
		$fixtureIds = $personalEncounters->getDataProperty('fixture_id');
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('id' => $fixtureIds)
		)));
		$fixtures = $modelTennisFixture->getData();

		// players from fixtures if poss
		if ($fixtures) {
			$modelTennisPlayer->read($this->getArchiveWhere(array(
				'where' => array('team_id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right')))
			)));
			$modelTennisPlayer->keyDataByProperty('id');
		}

		// teams
		if ($fixtures) {
			$modelTennisTeam
				->read($this->getArchiveWhere(array(
					'where' => array(
						'id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right'))
					)
				)))
				->keyDataByProperty('id');
		}
		$teams = $modelTennisTeam->getData();

		// all fixtures played in encounters
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
					'where' => array('fixture_id' => $fixtureIds)
				)));
		$modelTennisEncounter->convertToFixtureResults();
		$fixtureResults = $modelTennisEncounter->getData();

		// template
		$this->view
			->setMeta(array(		
				'title' => 'Player ' . $player->getNameFull()
			))
			->setDataKey('division', $modelTennisDivision->getDataFirst())
			->setDataKey('player', $player)
			->setDataKey('players', $modelTennisPlayer->getData())
			->setDataKey('team', $team)
			->setDataKey('teams', $teams)
			->setDataKey('acquaintances', $acquaintances)
			->setDataKey('fixtures', $fixtures)
			->setDataKey('fixtureResults', $fixtureResults)
			->setDataKey('encounters', $personalEncounters->getData())
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
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
					'where' => array('player_id_left' => $player->getId())
				)));
		$encounters = $modelTennisEncounter->getData();
		$modelTennisEncounter->read($this->getArchiveWhere(array(
					'where' => array('player_id_right' => $player->getId())
				)));
		$encounters = array_merge($encounters, $modelTennisEncounter->getData());
		$modelTennisEncounter->setData($encounters);
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounterCopy = new $className($this);
		$modelTennisEncounterCopy->setData($encounters);
		$this->setPersonalEncounters($modelTennisEncounterCopy);

		// convert encounters to merit results
		$modelTennisEncounter
			->filterStatus(array('doubles', 'exclude'))
			->convertToMerit()
			->orderByHighestAverage();

		// template
		$this->view
			->setDataKey('meritRows', $modelTennisEncounter->getData());
	}
}
