<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

use OriginalAppName\Site\Elttl\Model;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Fixture extends \OriginalAppName\Service
{


	public function readSummaryTable($entityYear, $entityDivision)
	{

		// teams in division keyed by teamId
		$modelTeam = new Model\Tennis\Team($this);
		$modelTeam
			->readDivisionId($entityYear->getId(), $entityDivision->getArchiveId())
			->keyDataByProperty('id')
			->getData();

echo '<pre>';
print_r($modelTeam);
echo '</pre>';
exit;


		// fixtures teams have played in
		// only need left side
		$modelFixture = new Model\Tennis\Fixture($this);
		$modelFixture->readId($modelTeam->getDataProperty('id'), 'teamIdLeft');

		// encounters based on fixtures
		$modelEncounter = new Model\Tennis\Encounter($this);
		$modelEncounter->readId($modelFixture->getDataProperty('id'), 'fixtureId');


		echo '<pre>';
		print_r($modelEncounter);
		echo '</pre>';
		exit;
		

		$modelEncounter->convertToFixtureResults();
		$fixtureResults = $modelEncounter->getData();

		// template
		$this
			->view
			->setDataKey('fixtureResults', $fixtureResults)
			->setDataKey('fixtures', $fixtures)
			->setDataKey('teams', $teams);
	}
}
