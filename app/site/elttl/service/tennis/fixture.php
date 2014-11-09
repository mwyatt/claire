<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

use OriginalAppName\Site\Elttl\Model\Tennis as ElttlModelTennis;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Fixture extends \OriginalAppName\Service
{


	public function readSummaryTable($divisionId)
	{
		$modelYear = new ElttlModelTennis\Year();
		$modelYear->readId([$id]);
		return current($modelYear->getData());




		// resource
		$division = $this->getDivision();

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTeam = new $className($this);
		$teams = $modelTeam
			->read($this->getArchiveWhere(array(
				'where' => array(
					'division_id' => $division->getId()
				)
			)))
			->keyByProperty('id')
			->getData();

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelFixture = new $className($this);
		$modelFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_left' => $modelTeam->getDataProperty('id'))
		)));
		$fixtures = array();

		// weed out only fulfilled fixtures
		foreach ($modelFixture->getData() as $fixture) {
			if ($fixture->getTimeFulfilled()) {
				$fixtures[] = $fixture;
			}
		}
		$modelFixture->setData($fixtures);

		// fixture results
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelFixture->getDataProperty('id'))
		)));
		$modelTennisEncounter->convertToFixtureResults();
		$fixtureResults = $modelTennisEncounter->getData();

		// template
		$this
			->view
			->setObject('fixtureResults', $fixtureResults)
			->setObject('fixtures', $fixtures)
			->setObject('teams', $teams);
	}
}
