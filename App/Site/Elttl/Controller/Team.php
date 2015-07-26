<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Site\Elttl\Controller\Front
{


	public function single($yearName, $teamSlug)
	{
		$serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
		if (!$entityYear = $serviceYear->readName($yearName)) {
		    return new \OriginalAppName\Response('', 404);
		}

		// team
		$modelTennisTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
		$modelTennisTeam->readYearColumn($entityYear->id, 'slug', $teamSlug);
		if (! $team = $modelTennisTeam->getDataFirst()) {
		    return new \OriginalAppName\Response('', 404);
		}

echo '<pre>';
print_r($team);
echo '</pre>';
exit;


		// players
		$className = $this->getArchiveClassName('model_tennis_player');
		$modelTennisPlayer = new $className($this);
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('team_id' => $team->getId())
		)));
		$modelTennisPlayer->keyDataByProperty('id');
		$players = $modelTennisPlayer->getData();

		// secretary
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('id' => $team->getSecretaryId())
		)));
		$secretary = $modelTennisPlayer->getDataFirst();

		// division
		$className = $this->getArchiveClassName('model_tennis_division');
		$modelTennisDivision = new $className($this);
		$modelTennisDivision->read($this->getArchiveWhere(array(
			'where' => array(
				'id' => $team->getDivisionId()
			)
		)));

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_left' => $team->getId())
		)));
		$fixturesLeft = $modelTennisFixture->getData();
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_right' => $team->getId())
		)));
		$fixturesRight = $modelTennisFixture->getData();
		$fixtures = array_merge($fixturesLeft, $fixturesRight);
		$modelTennisFixture->setData($fixtures);

		// teams
		$modelTennisTeam
			->read($this->getArchiveWhere(array(
				'where' => array(
					'id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right'))
				)
			)))
			->keyDataByProperty('id');
		$teams = $modelTennisTeam->getData();

		// all fixtures played in encounters
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));
		$modelTennisEncounter->convertToFixtureResults();
		$fixtureResults = $modelTennisEncounter->getData();

		// venue
		$className = $this->getArchiveClassName('model_tennis_venue');
		$modelTennisVenue = new $className($this);
		$modelTennisVenue->read($this->getArchiveWhere(array(
			'where' => array('id' => $team->getVenueId())
		)));
		$venue = $modelTennisVenue->getDataFirst();

		// template
		$this->view
			->setMeta(array(		
				'title' => $team->getName()
			))
			->setDataKey('team', $team)
			->setDataKey('teams', $teams)
			->setDataKey('venue', $venue)
			->setDataKey('division', $modelTennisDivision->getDataFirst())
			->setDataKey('secretary', $secretary)
			->setDataKey('fixtures', $modelTennisFixture->getData())
			->setDataKey('fixtureResults', $fixtureResults)
			->setDataKey('players', $players)
			->getTemplate('team-single');
	}
}
