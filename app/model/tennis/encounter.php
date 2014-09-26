<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Tennis_Encounter extends Model
{	


	public $fields = array(
		'id',
		'fixture_id',
		'score_left',
		'score_right',
		'player_id_left',
		'player_id_right',
		'player_rank_change_left',
		'player_rank_change_right',
		'status'
	);


	/**
	 * sets up all scores in a won / played configuration object
	 * excludes all statused rows
	 * @return object 
	 */
	public function convertToMerit()
	{
		if (! $molds = $this->getData()) {
			return $this;
		}
		$collection = array();
		foreach ($molds as $mold) {
			foreach (array('left', 'right') as $side) {

				// create object entry for player if not exist
				$playerId = $mold->{'player_id_' . $side};
				if (! array_key_exists($playerId, $collection)) {
					$collection[$playerId] = (object) array(
						'won' => 0,
						'played' => 0,
						'average' => null
					);
				}

				// get scores
				$score = $mold->{'score_' . $side};
				$opposingScore = $mold->{'score_' . $this->getOtherSide($side)};

				// adding only your points
				$collection[$playerId]->won += $score;

				// totaling win and other side score
				$collection[$playerId]->played += ($score + $opposingScore);
			}
		}

		// inject average
		foreach ($collection as $key => $singleCurated) {
			$collection[$key]->average = $this->calcAverage($singleCurated->won, $singleCurated->played);
		}

		// return [playerid], won, played, average objects
		$this->setData($collection);
		return $this;
	}


	public function convertToFixtureResults()
	{
		if (! $molds = $this->getData()) {
			return;
		}
		$collection = array();
		foreach ($molds as $mold) {

			// create object entry for player if not exist
			$fixtureId = $mold->getFixtureId();
			if (! array_key_exists($fixtureId, $collection)) {
				$collection[$fixtureId] = (object) array(
					'score_left' => 0,
					'score_right' => 0
				);
			}

			// get scores
			$collection[$fixtureId]->score_left += $mold->getScoreLeft();
			$collection[$fixtureId]->score_right += $mold->getScoreRight();
		}

		// return [fixtureId], won, played, average objects
		$this->setData($collection);
		return $this;
	}


	public function filterStatus($status = array())
	{
		$molds = $this->getData();
		foreach ($molds as $key => $mold) {
			if (in_array($mold->getStatus(), $status)) {
				unset($molds[$key]);
			}
		}
		$this->setData($molds);
		return $this;
	}


	/**
	 * calculates the average 0 to 100%
	 * @param  int $won    
	 * @param  int $played 
	 * @return int         percentage value of win / loss ratio
	 */
	public function calcAverage($won, $played) {
		$average = 0;
		if ( $played != 0 ) {
			$x = 0; $y = 0; $average = 0;			
			$x = $won / $played;
			$y = $x * 100;
			// $average = round($y); // converts to 65%
			$average = number_format((float)$y, 2, '.', '');
		}
	    return $average;
	} 


	public function orderByHighestAverage()
	{
		$data = $this->getData();
		uasort($data, function($a, $b) {
			if ($a->average == $b->average) {
				return 0;
			}
			return $a->average > $b->average ? -1 : 1;
		});
		$this->setData($data);
		return $this;
	}
}
