<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Fixture extends Controller_Index
{


	public function run()
	{

		// fixture/burnley-boys-club-vs-another-team/
		if ($this->url->getPathPart(1)) {
			$this->single();
		}
	}


	public function single()
	{

		// url part validation
		$required = ' vs ';
		$part = $this->url->getPathPart(1);
		$part = str_replace('-', ' ', $part);
		if (! strpos($part, $required)) {
			$this->route('base');
		}
		$teamNames = explode($required, $part);

		// team
		$modelTennisTeam = new model_tennis_Team($this);
		$modelTennisTeam->read(array(
			'where' => array(
				'name' => reset($teamNames)
			)
		));
		$teamLeft = $modelTennisTeam->getDataFirst();
		$modelTennisTeam->read(array(
			'where' => array(
				'name' => end($teamNames)
			)
		));
		$teamRight = $modelTennisTeam->getDataFirst();
		if (! $teamLeft || ! $teamRight) {
			$this->route('base');
		}
		$teamIds = array($teamLeft->getId(), $teamRight->getId());

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => $teamIds)
		));
		$modelTennisPlayer->keyByProperty('id');

		// division
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read(array(
			'where' => array(
				'id' => $teamLeft->getDivisionId()
			)
		));

		// fixture
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array(
				'team_id_left' => $teamLeft->getId(),
				'team_id_right' => $teamRight->getId()
			)
		));

		// encounter
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		));
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
