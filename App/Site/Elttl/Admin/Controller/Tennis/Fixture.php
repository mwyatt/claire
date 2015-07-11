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


	public function create()
	{
		$this->update(null);
	}


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

		// flag to know if filled, why?
		$isFilled = false;

		// get single fixture
		$modelTennisFixture = new Model\Tennis\Fixture;
		$modelTennisFixture->readYearColumn('id', $id);
		$fixture = $modelTennisFixture->getDataFirst();
		
		// find out if the fixture has been filled
		$modelTennisEncounter = new Model\Tennis\Encounter;
		$modelTennisEncounter->readYearColumn('fixtureId', $id);
		if ($modelTennisEncounter->getData()) {
			$modelTennisEncounter->orderByProperty('id');
			$isFilled = true;
		}

		// teams
		$modelTennisTeam = new Model\Tennis\Team;
		if ($isFilled) {
			$modelTennisTeam->readYearId([$fixture->teamIdLeft, $fixture->teamIdRight]);
 		} else {
			$modelTennisTeam->readColumn('yearId', $this->yearId);
		}

		// divisions
		$modelTennisDivision = new Model\Tennis\Division;
		if ($isFilled) {
			$modelTennisDivision->readYearId($modelTennisTeam->getDataProperty('divisionId'));
		} else {
			$modelTennisDivision->readColumn('yearId', $this->yearId);
		}

		// player
		$modelTennisPlayer = new Model\Tennis\Player;
		if ($isFilled) {
			$modelTennisPlayer
				->readYearId($modelTennisTeam->getDataProperty('id'), 'teamId')
				->orderByProperty('rank');
		} else {
			$modelTennisPlayer
				->readColumn('yearId', $this->yearId)
				->orderByProperty('nameLast', 'desc');
		}

		// reindex array, needed?
		$modelTennisPlayer->setData(array_values($modelTennisPlayer->getData()));

		// template
		$this->view
			->appendAsset('css', 'admin/tennis/fixture/single')
			->appendAsset('js', 'admin/tennis/fixture/single')
			->setDataKey('sides', ['left', 'right'])
			->setDataKey('isFilled', $isFilled)
			->setDataKey('fixture', $fixture)
			->setDataKey('divisions', $modelTennisDivision->getData())
			->setDataKey('teams', $modelTennisTeam->getData())
			->setDataKey('players', $modelTennisPlayer->getData())
			->setDataKey('encounters', $modelTennisEncounter->getData())
			->setDataKey('encounterStructure', $modelTennisFixture->getEncounterStructure());
		return new Response($this->view->getTemplate('admin/tennis/fixture/single'));
	}


	public function update($id)
	{
		$service = new \OriginalAppName\Site\Elttl\Admin\Service\Tennis\Fixture\Fulfill;
		$service->boot();
	}
}
