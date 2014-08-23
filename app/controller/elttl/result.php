<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Result extends Controller_Archive
{


	public $division;


	/**
	 * @return object mold
	 */
	public function getDivision() {
	    return $this->division;
	}
	
	
	/**
	 * @param object $division mold
	 */
	public function setDivision($division) {
	    $this->division = $division;
	    return $this;
	}


	public function run()
	{
		$this->readYear();

		// result/premier/
		// or archive/2013/result/premier/
		if ($this->getArchivePathPart(1)) {
			$this->division();
		} else {
			$this->divisionList();
		}
	}


	/**
	 * list of all divisions for current year
	 * @return null 
	 */
	public function divisionList()
	{
		$className = $this->getArchiveClassName('model_tennis_division');
		$modelTennisDivision = new $className($this);
		$modelTennisDivision->read($this->getArchiveWhere());
		
		// template
		$this->view
			->setMeta(array(		
				'title' => 'Divisions'
			))
			->setObject('divisions', $modelTennisDivision->getData())
			->getTemplate('division/list');
	}


	public function merit()
	{

		// resource
		$division = $this->getDivision();

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array('division_id' => $division->getId())
		)));
		$modelTennisTeam->keyByProperty('id');

		// players
		$className = $this->getArchiveClassName('model_tennis_player');
		$modelTennisPlayer = new $className($this);
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
		)));
		$modelTennisPlayer->keyByProperty('id');

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		)));

		// encounter
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));

		// convert encounters to merit results
		$modelTennisEncounter
			->removeStatus()
			->convertToMerit()
			->orderByHighestAverage();

		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' Merit'
			))
			->setObject('division', $division)
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('players', $modelTennisPlayer->getData())
			->setObject('meritStats', $modelTennisEncounter->getData())
			->getTemplate('division/merit');
	}


	public function league()
	{

		// resource
		$division = $this->getDivision();

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array('division_id' => $division->getId())
		)));
		$modelTennisTeam->keyByProperty('id');

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		));

		// encounter
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));

		// convert encounters to league results
		$modelTennisEncounter->convertToFixtureResults();
		$modelTennisFixture
			->convertToLeague($modelTennisEncounter->getData())
			->orderByHighestPoints();

		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' League'
			))
			->setObject('division', $division)
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('leagueStats', $modelTennisFixture->getData())
			->getTemplate('division/league');
	}


	public function division()
	{

		// division
		$className = $this->getArchiveClassName('model_tennis_division');
		$modelTennisDivision = new $className($this);
		$modelTennisDivision->read($this->getArchiveWhere(array(
			'where' => array(
				'name' => $this->getArchivePathPart(1)
			)
		)));
		$division = $modelTennisDivision->getDataFirst();
		if (! $division) {
			$this->route('base');
		}
		$this->setDivision($division);

		// result/premier/merit
		if ($table = $this->getArchivePathPart(2)) {
			if (in_array($table, array('merit', 'league'))) {
				return $this->$table();
			}
		}
		
		// single division view
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' division overview'
			))
			->setObject('division', $division)
			->getTemplate('division/overview');
	}
}
