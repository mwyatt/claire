<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Tennis_Fixture extends Model
{	


	public $fields = array(
		'id',
		'year_id',
		'team_id_left',
		'team_id_right',
		'time_fulfilled'
	);


	/**
	 * structure representing the encounter pattern for a standard
	 * table tennis league match
	 * @var array
	 */
	public $encounterStructure = array(
		0 => array(1, 2)
		, 1 => array(3, 1)
		, 2 => array(2, 3)
		, 3 => array(3, 2)
		, 4 => array(1, 3)
		, 5 => array('doubles', 'doubles')
		, 6 => array(2, 1)
		, 7 => array(3, 3)
		, 8 => array(2, 2)
		, 9 => array(1, 1)
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
		$this->keyByProperty('id');
		if (! $fixtureMolds = $this->getData()) {
			return;
		}
		$collection = array();
		foreach ($fixtureScores as $key => $fixtureScore) {
			if (! array_key_exists($key, $fixtureMolds)) {
				return;
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
}
