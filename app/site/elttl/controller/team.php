<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Team extends Controller_Archive
{


	public $team;


	/**
	 * @return object 
	 */
	public function getTeam() {
	    return $this->team;
	}
	
	
	/**
	 * @param object $team 
	 */
	public function setTeam($team) {
	    $this->team = $team;
	    return $this;
	}


	public function run()
	{
		$this->readYear();

		// team/burnley-boys-club/
		if ($this->getArchivePathPart(1)) {
			return $this->single();
		}
		$this->route('base');
	}


	public function single()
	{

		// team
		$className = $this->getArchiveClassName('model_tennis_Team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array(
				'name' => str_replace('-', ' ', $this->getArchivePathPart(1))
			)
		)));
		if (! $team = $modelTennisTeam->getDataFirst()) {
			$this->route('base');
		}
		$this->setTeam($team);

		// players
		$className = $this->getArchiveClassName('model_tennis_player');
		$modelTennisPlayer = new $className($this);
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('team_id' => $team->getId())
		)));
		$modelTennisPlayer->keyDataByProperty('id');
		$players = $modelTennisPlayer->getData();

		// secretary
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('id' => $team->getSecretaryId())
		)));
		$secretary = $modelTennisPlayer->getDataFirst();

		// division
		$className = $this->getArchiveClassName('model_tennis_division');
		$modelTennisDivision = new $className($this);
		$modelTennisDivision->read($this->getArchiveWhere(array(
			'where' => array(
				'id' => $team->getDivisionId()
			)
		)));

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_left' => $team->getId())
		)));
		$fixturesLeft = $modelTennisFixture->getData();
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_right' => $team->getId())
		)));
		$fixturesRight = $modelTennisFixture->getData();
		$fixtures = array_merge($fixturesLeft, $fixturesRight);
		$modelTennisFixture->setData($fixtures);

		// teams
		$modelTennisTeam
			->read($this->getArchiveWhere(array(
				'where' => array(
					'id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right'))
				)
			)))
			->keyDataByProperty('id');
		$teams = $modelTennisTeam->getData();

		// all fixtures played in encounters
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));
		$modelTennisEncounter->convertToFixtureResults();
		$fixtureResults = $modelTennisEncounter->getData();

		// venue
		$className = $this->getArchiveClassName('model_tennis_venue');
		$modelTennisVenue = new $className($this);
		$modelTennisVenue->read($this->getArchiveWhere(array(
			'where' => array('id' => $team->getVenueId())
		)));
		$venue = $modelTennisVenue->getDataFirst();

		// template
		$this->view
			->setMeta(array(		
				'title' => $team->getName()
			))
			->setObject('team', $team)
			->setObject('teams', $teams)
			->setObject('venue', $venue)
			->setObject('division', $modelTennisDivision->getDataFirst())
			->setObject('secretary', $secretary)
			->setObject('fixtures', $modelTennisFixture->getData())
			->setObject('fixtureResults', $fixtureResults)
			->setObject('players', $players)
			->getTemplate('team-single');
	}
}
