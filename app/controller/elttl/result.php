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


	public function run()
	{

		// result/premier/
		if ($this->url->getPathPart(1)) {
			$this->division();
		} else {
			$this->divisionList();
		}
		$this->route('base');
	}


	public function divisionList()
	{
		echo '<pre>';
		print_r('divisionList');
		echo '</pre>';
		exit;
		
	}


	public function merit()
	{

		// team
		$division = $this->getDivision();
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array('division_id' => $division->getId())
		));

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
		));
		$modelTennisPlayer->arrangeByProperty('id');

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
			->setObject('meritRows', $modelTennisEncounter->getData())
			->getTemplate('league');
	}


	public function league()
	{

		// team
		$division = $this->getDivision();
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array('division_id' => $division->getId())
		));

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
			->setObject('leagueRows', $modelTennisFixture->getData())
			->getTemplate('league');
	}


	public function division()
	{
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read(array(
			'where' => array(
				'name' => $this->url->getPathPart(1)
			)
		));
		if (! $theDivision = $modelTennisDivision->getDataFirst()) {
			return;
		}

		// result/premier/merit
		if ($table = $this->url->getPathPart(2)) {
			if (in_array($table, array('merit', 'league'))) {
				$this->$table();
			}
		}
		
		// single division view
		$this->view
			->setMeta(array(		
				'title' => $theDivision->getName() . ' Division Summary'
			))
			->setObject('division', $theDivision)
			->getTemplate('division-single');
	}
}
