<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Result extends Controller_Index
{


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

		// result/premier/
		if ($this->url->getPathPart(1)) {
			$this->division();
		} else {
			$this->divisionList();
		}
		$this->route('base');
	}


	public function divisionList()
	{
		echo '<pre>';
		print_r('divisionList');
		echo '</pre>';
		exit;
		
	}


	public function merit()
	{

		// team
		$division = $this->getDivision();
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array('division_id' => $division->getId())
		));

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
		));

		// fixture
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		));

		// encounter
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		));

		// convert encounters to merit results
		$modelTennisEncounter
			->removeStatus()
			->convertToMerit()
			->orderByHighestAverage();

		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' Merit'
			))
			->setObject('division', $division)
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('players', ??????)
			->getTemplate('league');
	}


	public function league()
	{

		// team
		$division = $this->getDivision();
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array('division_id' => $division->getId())
		));

		// fixture
		$modelTennisFixture = new model_tennis_fixture($this);
		$modelTennisFixture->read(array(
			'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
		));

		// encounter
		$modelTennisEncounter = new model_tennis_encounter($this);
		$modelTennisEncounter->read(array(
			'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
		));

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
			->setObject('leagueRows', $modelTennisFixture->getData())
			->getTemplate('league');
	}


	public function division()
	{
		$modelTennisDivision = new model_tennis_division($this);
		if (! $modelTennisDivision->read()) {
			return;
		}
		$urlDivision = $this->url->getPathPart(1);
		foreach ($modelTennisDivision->getData() as $moldDivision) {
			if (strtolower($moldDivision->getName()) == $urlDivision) {
				$this->setDivision($moldDivision);
				break;
			}
		}
		if (! $theDivision = $this->getDivision()) {
			return;
		}

		// result/premier/merit
		if ($table = $this->url->getPathPart(2)) {
			if (in_array($table, array('merit', 'league'))) {
				$this->$table();
			}
		}
		
		// single division view
		$this->view
			->setMeta(array(		
				'title' => $theDivision->getName() . ' Division Summary'
			))
			->setObject('division', $theDivision)
			->getTemplate('division-single');
	}


	public function single()
	{

		// type/slug/
		if (! $this->url->getPathPart(1)) {
			return;
		}

		// read by slug and type
		$modelContent = new model_content($this);
		if (! $modelContent->read(array(
			'where' => array(
				'slug' => $this->url->getPathPart(1),
				'status' => 'visible',
				'type' => $this->url->getPathPart(0)
			)
		))) {
			$this->route('base');
		}
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');

		// set view
		$this->view
			->setMeta(array(		
				'title' => $modelContent->getData('title')
			))
			->setObject('contents', $modelContent)
			->getTemplate('content-single');
		return true;
	}


	public function all() {

		// post/ only
		if ($this->url->getPathPart(1)) {
			$this->route('base');
		}

		// load
		$pagination = new pagination($this);
		$cache = new cache($this);
		$pagination->setTotalRows($cache->read('ceil-content-' . $this->url->getPathPart(0)));
		$pagination->initialise();
		$modelContent = new model_content($this);
		$modelContent->read(array(
			'where' => array(
				'type' => $this->url->getPathPart(0),
				'status' => 'visible'
			),
			'limit' => $pagination->getLimit(),
			'order_by' => 'time_published desc'
		));
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
		$firstContent = $modelContent->getData();
		$this->view
			->setMeta(array(		
				'title' => 'All posts'
			))
			->setObject('pageCurrent', $pagination->getCurrentPage())
			->setObject('pagination_summary', $pagination->getSummary())
			->setObject('first_content', current($firstContent))
			->setObject($pagination)
			->setObject('contents', $modelContent)
			->getTemplate('content');
		return true;
	}
}
