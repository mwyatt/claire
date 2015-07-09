<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Encounter extends \OriginalAppName\Site\Elttl\Model\Tennis
{	


	public $tableName = 'tennisEncounter';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Encounter';


	public $fields = [
		'id',
		'yearId',
		'fixtureId',
		'playerIdLeft',
		'playerIdRight',
		'scoreLeft',
		'scoreRight',
		'playerRankChangeLeft',
		'playerRankChangeRight',
		'fixtureId',
		'status'
	];


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
