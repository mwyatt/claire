<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Admin_Tennis_Fixture extends Controller_Admin
{


	public $fixtureId;


	/**
	 * @return int 
	 */
	public function getFixtureId() {
	    return $this->fixtureId;
	}
	
	
	/**
	 * @param int $fixtureId 
	 */
	public function setFixtureId($fixtureId) {
	    $this->fixtureId = $fixtureId;
	    return $this;
	}


	public function run()
	{

		// generating
		if (array_key_exists('generate', $_REQUEST)) {
			$modelTennisFixture = new model_tennis_Fixture($this);
			$modelTennisFixture->generate();
			$this->route('current');
		}

		// updating
		if (array_key_exists('division_id', $_REQUEST)) {
			$this->update();
		}

		// single
		if (array_key_exists('fixture_id', $_REQUEST)) {
			$this->setFixtureId($_REQUEST['fixture_id']);
			return $this->single();
		}

		// fulfill
		if ($this->url->getPathPart(3)) {
			return $this->single();
		}

		// all
		$this->read();
	}


	/**
	 * get list of all
	 * @return null 
	 */
	public function read()
	{
		$modelTennisFixture = new model_tennis_Fixture($this);
		$modelTennisFixture
			->read()
			->orderByPropertyIntDesc('team_id_left');
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam
			->read()
			->keyByProperty('id');
		$modelTennisDivision = new model_tennis_Division($this);
		$modelTennisDivision->read();
		$this->view
			->setObject('divisions', $modelTennisDivision->getData())
			->setObject('fixtures', $modelTennisFixture->getData())
			->setObject('teams', $modelTennisTeam->getData())
			->getTemplate('admin/tennis/fixture/list');
	}


	/**
	 * get single for edit or new
	 * find out if is already filled based on the isFilled flag
	 * then load only what is required
	 * @return null 
	 */
	public function single()
	{

		// flag to mark if the fixture has been filled
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $this->getFixtureId()),
			'order_by' => 'id'
		));
		$isFilled = false;
		if ($modelTennisEncounter->getData()) {
			$isFilled = true;
		}

		// fixtures
		$modelTennisFixture = new model_tennis_Fixture($this);
		if ($isFilled) {
			$modelTennisFixture->read(array(
				'where' => array('id' => $this->getFixtureId())
			));
		}
		$fixture = $modelTennisFixture->getDataFirst();

		// teams
		$modelTennisTeam = new model_tennis_team($this);
		if ($isFilled) {
			$modelTennisTeam->read(array(
				'where' => array('id' => array(
					$fixture->getTeamIdLeft(),
					$fixture->getTeamIdRight()
				))
			));
 		} else {
			$modelTennisTeam->read();
		}

		// divisions
		$modelTennisDivision = new model_tennis_Division($this);
		if ($isFilled) {
			$modelTennisDivision->read(array(
				'where' => array('id' => $modelTennisTeam->getDataProperty('division_id'))
			));
		} else {
			$modelTennisDivision->read();
		}

		// player
		$modelTennisPlayer = new model_tennis_Player($this);
		if ($isFilled) {
			$modelTennisPlayer->read(array(
				'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
			));
		} else {
			$modelTennisPlayer->read();
		}
		$modelTennisPlayer->orderByPropertyIntAsc('rank');
		$modelTennisPlayer->setData(array_values($modelTennisPlayer->getData()));

		// template
		$this->view
			->setObject('isFilled', $isFilled)
			->setObject('divisions', $modelTennisDivision)
			->setObject('players', $modelTennisPlayer)
			->setObject('encounters', $modelTennisEncounter)
			->setObject('fixture', $fixture)
			->setObject('encounterStructure', $modelTennisFixture->getEncounterStructure())
			->setObject('teams', $modelTennisTeam)
			->getTemplate('admin/tennis/fixture/single');
	}


	/**
	 * update a row
	 * @return null 
	 */
	public function update()
	{
		$tennisFulfill = new tennis_fulfill($this);
		$tennisFulfill->run();
	}
}
