<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;

use \PDO;
use OriginalAppName\Registry;
use OriginalAppName\Site\Elttl\Model\Tennis as ModelTennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Model\Tennis
{	


	public $tableName = 'tennisFixture';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Fixture';


	public $fields = array(
		'id',
		'yearId',
		'teamIdLeft',
		'teamIdRight',
		'timeFulfilled'
	);


	/**
	 * structure representing the player positioning for a standard
	 * table tennis league match
	 * @var array
	 */
	public $encounterStructure = [
		[1, 2],
		[3, 1],
		[2, 3],
		[3, 2],
		[1, 3],
		['doubles', 'doubles'],
		[2, 1],
		[3, 3],
		[2, 2],
		[1, 1]
	];


	/**
	 * @return array 
	 */
	public function getEncounterStructure() {
	    return $this->encounterStructure;
	}
	
	
	/**
	 * @param array $encounterStructure 
	 */
	public function setEncounterStructure($encounterStructure) {
	    $this->encounterStructure = $encounterStructure;
	    return $this;
	}


	public function convertToLeague($fixtureScores)
	{
		$this->keyDataByProperty('id');
		if (! $fixtureMolds = $this->getData()) {
			return $this;
		}
		$collection = array();
		foreach ($fixtureScores as $key => $fixtureScore) {
			if (! array_key_exists($key, $fixtureMolds)) {
				return $this;
			}
			foreach (array('left', 'right') as $side) {
				$teamId = $fixtureMolds[$key]->{'team_id_' . $side};
				$scores = $fixtureScores[$key];

				// init key for team
				if (! array_key_exists($teamId, $collection)) {
					$collection[$teamId] = (object) array(
						'won' => 0,
						'draw' => 0,
						'loss' => 0,
						'played' => 0,
						'points' => 0
					);
				}

				// get scores
				$score = $scores->{'score_' . $side};
				$opposingScore = $scores->{'score_' . $this->getOtherSide($side)};

				// calculate won, loss, played, points
				$collection[$teamId]->played ++;
				$collection[$teamId]->points += $score;

				// draw
				if ($score == $opposingScore) {
					$collection[$teamId]->draw ++;
					continue;
				}

				// won
				if ($score > $opposingScore) {
					$collection[$teamId]->won ++;
					continue;

				// loss
				} else {
					$collection[$teamId]->loss ++;
				}
			}
		}
		$this->setData($collection);
		return $this;
	}


	public function orderByHighestPoints()
	{
		$data = $this->getData();
		uasort($data, function($a, $b) {
			if ($a->points == $b->points) {
				return 0;
			}
			return $a->points > $b->points ? -1 : 1;
		});
		$this->setData($data);
		return $this;
	}


	/**
	 * generates each fixture seperated by division
	 * teams must not change division beyond this point
	 * @return null
	 */
	public function generate() {
		$registry = Registry::getInstance();
		$yearId = $registry->get('database/options/yearId');
		$divisions = [];

		// delete all fixtures
		$sth = $this->database->dbh->query("	
			delete from
				tennisFixture
			where id != 0 and yearId = $yearId
		");

		// delete all encounters
		$sth = $this->database->dbh->query("	
			delete from
				tennisEncounter
			where id != 0 and yearId = $yearId
		");

		// select all divisions
		$modelDivision = new ModelTennis\Division;
		$modelDivision
			->readColumn('yearId', $yearId)
			->keyDataByProperty('id');

		// select all teams
		$modelTeam = new ModelTennis\Team;
		$modelTeam
			->readColumn('yearId', $yearId)
			->keyDataByProperty('id');

		// bind teams with divisions
		foreach ($modelDivision->getData() as $division) {
			if (empty($divisions[$division->id])) {
				$divisions[$division->id] = [];
			}
			foreach ($modelTeam->getData() as $team) {
				if ($team->divisionId == $division->id) {
					$divisions[$division->id][$team->id] = $team;
				}
			}
		}

		// prepare insert
		$sth = $this->database->dbh->prepare("
			insert into
				tennisFixture
				(
					yearId,
					teamIdLeft,
					teamIdRight
				)
			values
				(
					$yearId,
					:teamIdLeft,
					:teamIdRight
				)
		");				
				
		// loop to set team vs team fixtures
		foreach ($divisions as $teams) {
			foreach ($teams as $homeTeam) {
				foreach ($teams as $awayTeam) {
					if ($homeTeam->id !== $awayTeam->id) {
						$sth->execute(array(
							':teamIdLeft' => $homeTeam->id,
							':teamIdRight' => $awayTeam->id
						));					
					}
				}
			}
		}
		return true;
	}
}
