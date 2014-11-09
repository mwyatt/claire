<?php

namespace OriginalAppName\Site\Elttl\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as SymfonyResourceNotFound;
use OriginalAppName\Model;
use OriginalAppName\Site\Elttl\Model\Tennis as ElttlModelTennis;
use OriginalAppName\View;
use OriginalAppName\Site\Elttl\Service\Tennis as ElttlServiceTennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Result extends \OriginalAppName\Controller
{


	/**
	 * every year past and present for the league
	 * @return object 
	 */
	public static function all()
	{
		$modelYear = new ElttlModelTennis\Year();
		$modelYear
			->read()
			->orderByProperty('name', 'desc');
		if (! $modelYear->getData()) {
			throw new SymfonyResourceNotFound();
		}

		// template
		$view = new View([
			'metaTitle' => 'All seasons',
			'years' => $modelYear->getData()
		]);
		return new Response($view->getTemplate('year'));
	}


	/**
	 * list of all divisions for current year
	 * @return null 
	 */
	public static function year($name)
	{

		// year, make this more global?
		$serviceYear = new ElttlServiceTennis\Year();
		$yearSingle = $serviceYear->readName($name);

		// division
		$modelDivision = new ElttlModelTennis\Division();
		$modelDivision->readId([$yearSingle->getId()], 'yearId');
		if (! $modelDivision->getData()) {
			throw new SymfonyResourceNotFound();
		}

		// template
		$view = new View([
			'metaTitle' => 'Divisions in season ' . $yearSingle->getNameFull(),
			'divisions' => $modelDivision->getData(),
			'yearSingle' => $yearSingle
		]);
		return new Response($view->getTemplate('tennis/division-list'));
	}


	/**
	 * initialises the division which is in the current url path
	 * and stores in the division property
	 * moves to merit || league from here
	 * @return null 
	 */
	public static function division($year, $division)
	{

		// year, make this more global?
		$serviceYear = new ElttlServiceTennis\Year();
		$yearSingle = $serviceYear->readName($year);
		if (! $yearSingle) {
			throw new SymfonyResourceNotFound();
		}

		// division
		$modelDivision = new ElttlModelTennis\Division();
		$modelDivision->readId([$yearSingle->getId()], 'yearId');
		if (! $modelDivision->getData()) {
			throw new SymfonyResourceNotFound();
		}
		$divisionSingle = current($modelDivision->getData());

		// tables
		if (isset($_REQUEST['table'])) {
			
		}

		// ?table=merit,league,merit-double


		// tables
		// merit
			// merit-double
		// league


		// result/premier/merit
		if ($table = $this->getArchivePathPart(2)) {
			if (in_array($table, array('merit', 'league'))) {
				return $this->$table();
			}
		}
		
		// fixture summary table
		$this->readFixtureSummaryTable();
		$serviceFixture = new ElttlServiceTennis\Fixture();
		// $ = $serviceFixture->readSummaryTable($name);


		// single division view
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' division overview'
			))
			->setObject('division', $division)
			->getTemplate('division/overview');
	}


	public function meritDoubles()
	{
		
		// resource
		$division = $this->getDivision();

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array('division_id' => $division->getId())
		)));
		$modelTennisTeam->keyByProperty('id');

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		)));

		// encounter
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));

		// convert encounters to merit results
		$modelTennisEncounter
			->filterStatus(array('', 'exclude'))
			->convertToFixtureResults();

		// convert encounter conversion, keyed by team id
		$modelTennisFixture
			->convertToLeague($modelTennisEncounter->getData())
			->orderByHighestPoints();

		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' doubles merit'
			))
			->setObject('division', $division)
			->setObject('tableName', 'doubles merit')
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('leagueStats', $modelTennisFixture->getData())
			->getTemplate('division/league');
	}


	public function merit()
	{
		if ($this->getArchivePathPart(3) == 'doubles') {
			return $this->meritDoubles();
		}

		// resource
		$division = $this->getDivision();

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array('division_id' => $division->getId())
		)));
		$modelTennisTeam->keyByProperty('id');

		// players
		$className = $this->getArchiveClassName('model_tennis_player');
		$modelTennisPlayer = new $className($this);
		$modelTennisPlayer->read($this->getArchiveWhere(array(
			'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
		)));
		$modelTennisPlayer->keyByProperty('id');

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read($this->getArchiveWhere(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		)));

		// encounter
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));

		// convert encounters to merit results
		$modelTennisEncounter
			->filterStatus(array('doubles', 'exclude'))
			->convertToMerit()
			->orderByHighestAverage();

		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' Merit'
			))
			->setObject('division', $division)
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('players', $modelTennisPlayer->getData())
			->setObject('meritStats', $modelTennisEncounter->getData())
			->getTemplate('division/merit');
	}


	public function league()
	{

		// resource
		$division = $this->getDivision();

		// team
		$className = $this->getArchiveClassName('model_tennis_team');
		$modelTennisTeam = new $className($this);
		$modelTennisTeam->read($this->getArchiveWhere(array(
			'where' => array('division_id' => $division->getId())
		)));
		$modelTennisTeam->keyByProperty('id');

		// fixture
		$className = $this->getArchiveClassName('model_tennis_fixture');
		$modelTennisFixture = new $className($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		));

		// encounter
		$className = $this->getArchiveClassName('model_tennis_encounter');
		$modelTennisEncounter = new $className($this);
		$modelTennisEncounter->read($this->getArchiveWhere(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		)));

		// convert encounters to league results
		$modelTennisEncounter->convertToFixtureResults();
		$modelTennisFixture
			->convertToLeague($modelTennisEncounter->getData())
			->orderByHighestPoints();

		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' League'
			))
			->setObject('division', $division)
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('tableName', 'league')
			->setObject('leagueStats', $modelTennisFixture->getData())
			->getTemplate('division/league');
	}


	public $division;


	/**
	 * @return object mold
	 */
	public function getDivision() {
	    return $this->division;
	}
	
	
	/**
	 * @param object $division mold
	 */
	public function setDivision($division) {
	    $this->division = $division;
	    return $this;
	}


	public function run()
	{
		$this->readYear();

		// result/premier/
		// or archive/2013/result/premier/
		if ($this->getArchivePathPart(1)) {
			$this->division();
		} else {
			$this->divisionList();
		}
	}
}
