<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Model\Tennis\Archive
{	


	public $tableName = 'tennis_fixture';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Fixture';


	public $fields = array(
		'id',
		'teamArchiveIdLeft',
		'teamArchiveIdRight',
		'timeFulfilled'
	);


	/**
	 * structure representing the player positioning for a standard
	 * table tennis league match
	 * @var array
	 */
	public $encounterStructure = array(
		array(1, 2),
		array(3, 1),
		array(2, 3),
		array(3, 2),
		array(1, 3),
		array('doubles', 'doubles'),
		array(2, 1),
		array(3, 3),
		array(2, 2),
		array(1, 1)
	);






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

		// clear all fixtures
		$sth = $this->database->dbh->query("	
			delete from
				tennis_fixture
			where id != 0
		");

		// clear all encounters
		$sth = $this->database->dbh->query("	
			delete from
				tennis_encounter
			where id != 0
		");

		// select all divisions
		$sth = $this->database->dbh->query("	
			SELECT
				tennis_division.id as division_id
				, tennis_team.id as team_id
			FROM
				tennis_division				
			LEFT JOIN tennis_team ON tennis_division.id = tennis_team.division_id
		");
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$this->data[$row['division_id']][] = $row['team_id'];
		}						
		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tennis_fixture
				(team_id_left, team_id_right)
			VALUES
				(:team_id_left, :team_id_right)
		");				
				
		// loop to set team vs team fixtures
		foreach ($this->data as $division) {
			foreach ($division as $key => $homeTeam) {
				foreach ($division as $key => $awayTeam) {
					if ($homeTeam !== $awayTeam) {
						$sth->execute(array(
							':team_id_left' => $homeTeam
							, ':team_id_right' => $awayTeam
						));					
					}
				}
			}
		}

		// feedback
		echo '<pre>';
		print_r('all fixtures and encounters removed, and fixtures re-generated using current team configuration');
		echo '</pre>';
		exit;
	}
}
