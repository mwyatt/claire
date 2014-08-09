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
		$this->route('base');
	}


	public function single()
	{

		// url part validation
		$required = ' vs ';
		$part = $this->url->getPathPart(1);
		$part = str_replace('-', ' ', $part);
		if (! strpos($part, $required)) {
			return;
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
			return;
		}
		$teamIds = array($teamLeft->getId(), $teamRight->getId());

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => $teamIds)
		));
		$modelTennisPlayer->arrangeByProperty('id');

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

		// convert to league stats
		$modelTennisEncounter->convertToFixtureResults();
		$modelTennisFixture->convertToLeague($modelTennisEncounter->getData());

		// template
		$this->view
			->setMeta(array(		
				'title' => $teamLeft->getName() . ' vs ' . $teamRight->getName()
			))
			->setObject('teamLeft', $teamLeft)
			->setObject('teamRight', $teamRight)
			->setObject('division', $modelTennisDivision->getData())
			->setObject('fixture', $modelTennisFixture->getDataFirst())
			->setObject('encounters', $modelTennisEncounter->getData())
			->setObject('players', $modelTennisPlayer->getData())
			->getTemplate('fixture-single');
	}
}
