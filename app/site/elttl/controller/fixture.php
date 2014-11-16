<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Fixture extends Controller_Archive
{


	public function run()
	{
		$this->readYear();

		// fixture/burnley-boys-club-vs-another-team/
		if ($this->url->getPathPart(1)) {
			$this->single();
		}
	}


	public function single()
	{

		// url part validation
		$required = ' vs ';
		$part = $this->getArchivePathPart(1);
		$part = str_replace('-', ' ', $part);
		if (! strpos($part, $required)) {
			$this->route('base');
		}
		$teamNames = explode($required, $part);

		// team
		$className = $this->getArchiveClassName('model_tennis_Team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array(
				'name' => reset($teamNames)
			)
		)));
		$teamLeft = $modelTennisTeam->getDataFirst();
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array(
				'name' => end($teamNames)
			)
		)));
		$teamRight = $modelTennisTeam->getDataFirst();
		if (! $teamLeft || ! $teamRight) {
			$this->route('base');
		}
		$teamIds = array($teamLeft->getId(), $teamRight->getId());

		// players
		$className = $this->getArchiveClassName('model_tennis_player');
		$modelTennisPlayer = new $className($this);
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('team_id' => $teamIds)
		)));
		$modelTennisPlayer->keyDataByProperty('id');

		// division
		$className = $this->getArchiveClassName('model_tennis_division');
		$modelTennisDivision = new $className($this);
		$modelTennisDivision->read($this->getArchiveWhere(array(
			'where' => array(
				'id' => $teamLeft->getDivisionId()
			)
		)));

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array(
				'team_id_left' => $teamLeft->getId(),
				'team_id_right' => $teamRight->getId()
			)
		)));

		// must be fulfilled
		$fixture = $modelTennisFixture->getDataFirst();
		if (! $fixture->getTimeFulfilled()) {
			$this->route('base');
		}

		// encounter
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));
		$encounters = $modelTennisEncounter->getData();

		// convert to league stats
		$modelTennisEncounter->convertToFixtureResults();

		// template
		$this->view
			->setMeta(array(		
				'title' => $teamLeft->getName() . ' vs ' . $teamRight->getName()
			))
			->setObject('teamLeft', $teamLeft)
			->setObject('teamRight', $teamRight)
			->setObject('division', $modelTennisDivision->getDataFirst())
			->setObject('fixture', $modelTennisFixture->getDataFirst())
			->setObject('fixtureResult', $modelTennisEncounter->getDataFirst())
			->setObject('encounters', $encounters)
			->setObject('players', $modelTennisPlayer->getData())
			->getTemplate('fixture-single');
	}
}
