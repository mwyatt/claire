<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Result extends Controller_Index
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


	/**
	 * @return int 
	 */
	public function getYear() {
	    return $this->year;
	}
	
	
	/**
	 * @param int $year 
	 */
	public function setYear($year) {
	    $this->year = $year;
	    return $this;
	}


	public function readYear()
	{
		if ($this->url->getPathPart(0) != 'archive') {
			return;

			
		}
		
			$modelTennisDivision = new model_tennis_division($this);
			$modelTennisDivision->read();

			$this->url->getPathPart(1)
	}


	public function run()
	{
		$this->readYear();

		// result/premier/
		if ($this->url->getPathPart(1)) {
			$this->division();
		} else {
			$this->divisionList();
		}
	}


	public function divisionList()
	{

		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read();
		
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

		// team
		$division = $this->getDivision();
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array('division_id' => $division->getId())
		));
		$modelTennisTeam->keyByProperty('id');

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
		));
		$modelTennisPlayer->keyByProperty('id');

		// fixture
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		));

		// encounter
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		));

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

		// team
		$division = $this->getDivision();
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array('division_id' => $division->getId())
		));
		$modelTennisTeam->keyByProperty('id');

		// fixture
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		));

		// encounter
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		));

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
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read(array(
			'where' => array(
				'name' => $this->url->getPathPart(1)
			)
		));
		$division = $modelTennisDivision->getDataFirst();
		if (! $division) {
			$this->route('base');
		}
		$this->setDivision($division);

		// result/premier/merit
		if ($table = $this->url->getPathPart(2)) {
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
