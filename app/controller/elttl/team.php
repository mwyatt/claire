<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Team extends Controller_Index
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

		// team/burnley-boys-club/
		if ($this->url->getPathPart(1)) {
			$this->single();
		}
		$this->route('base');
	}


	public function single()
	{

		// team
		$modelTennisTeam = new model_tennis_Team($this);
		$modelTennisTeam->read(array(
			'where' => array(
				'name' => str_replace('-', ' ', $this->url->getPathPart(1))
			)
		));
		if (! $team = $modelTennisTeam->getDataFirst()) {
			return;
		}
		$this->setTeam($team);

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => $team->getId())
		));
		$modelTennisPlayer->arrangeByProperty('id');

		// division
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read(array(
			'where' => array(
				'id' => $team->getDivisionId()
			)
		));

		// fixture
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $team->getId())
		));

		// encounter
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		));

		// convert to league stats
		$modelTennisEncounter->convertToFixtureResults();
		$modelTennisFixture->convertToLeague($modelTennisEncounter->getData());

		// template
		$this->view
			->setMeta(array(		
				'title' => $team->getName()
			))
			->setObject('team', $team)
			->setObject('division', $modelTennisDivision->getData())
			->setObject('fixtures', $modelTennisFixture->getData())
			->setObject('players', $modelTennisPlayer->getData())
			->getTemplate('team-single');
	}
}
