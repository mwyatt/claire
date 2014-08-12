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

		// single
		if (array_key_exists('fixture_id', $_REQUEST)) {
			$this->setFixtureId($_REQUEST['fixture_id']);
			return $this->single();
		}

		// update
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
	 * get single for edit
	 * @return null 
	 */
	public function single()
	{

		// encounters
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $this->getFixtureId())
		));
		if ($modelTennisEncounter->getData()) {
			$isFilled = true;
		}

		// fixtures
		$modelTennisFixture = new model_tennis_Fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('id' => $this->getFixtureId())
		));
		$fixture = $modelTennisFixture->getDataFirst();

		// teams
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam
			->read(array(
				'where' => array('id' => array(
					$fixture->getTeamIdLeft(),
					$fixture->getTeamIdRight()
				))
			))
			->keyByProperty('id');

		// template
		$this->view
			->setObject('encounters', $modelTennisEncounter->getData())
			->setObject('fixture', $fixture)
			->setObject('teams', $modelTennisTeam)
			->setObject('tabIndex', 1)
			->getTemplate('admin/tennis/fixture/single');
	}


	/**
	 * update a row
	 * @return null 
	 */
	public function update()
	{
		$tennisFulfill = new tennis_fulfill($this);
	}
}
