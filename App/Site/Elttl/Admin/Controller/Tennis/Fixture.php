<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Response;
use OriginalAppName\Registry;
use OriginalAppName\Session;
use OriginalAppName\Site\Elttl\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Admin\Controller\Tennis\Crud
{


	/**
	 * @return object 
	 */
	public function all() {
		$modelTennisFixture = new Model\Tennis\Fixture;
		$modelTennisFixture
			->readColumn('yearId', $this->yearId)
			->orderByProperty('teamIdLeft', 'desc');
		$modelTennisTeam = new Model\Tennis\Team;
		$modelTennisTeam
			->readColumn('yearId', $this->yearId)
			->keyDataByProperty('id');
		$modelTennisDivision = new Model\Tennis\Division;
		$modelTennisDivision->readColumn('yearId', $this->yearId);
		$this->view
			->setDataKey('divisions', $modelTennisDivision->getData())
			->setDataKey('fixtures', $modelTennisFixture->getData())
			->setDataKey('teams', $modelTennisTeam->getData());
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/all"));
	}


	public function single($id = 0)
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
			$modelTennisPlayer
				->read(array(
					'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
				))
				->orderByPropertyIntAsc('rank');
		} else {
			$modelTennisPlayer
				->read()
				->orderByPropertyStringDesc('name_last');
		}
		$modelTennisPlayer->setData(array_values($modelTennisPlayer->getData()));

		// template
		$this->view
			->setDataKey('isFilled', $isFilled)
			->setDataKey('divisions', $modelTennisDivision)
			->setDataKey('players', $modelTennisPlayer)
			->setDataKey('encounters', $modelTennisEncounter)
			->setDataKey('fixture', $fixture)
			->setDataKey('encounterStructure', $modelTennisFixture->getEncounterStructure())
			->setDataKey('teams', $modelTennisTeam)
			->getTemplate('admin/tennis/fixture/single');
	}
}
