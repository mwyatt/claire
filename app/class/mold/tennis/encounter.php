<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Tennis_Encounter extends Mold
{

	
	public $fixture_id;

	
	public $score_left;

	
	public $score_right;

	
	public $player_id_left;

	
	public $player_id_right;

	
	public $player_rank_change_left;

	
	public $player_rank_change_right;

	
	public $status;


	/**
	 * @return int 
	 */
	public function getfixtureId() {
	    return $this->fixture_id;
	}
	
	
	/**
	 * @param int $fixtureId 
	 */
	public function setfixtureId($fixtureId) {
	    $this->fixture_id = $fixtureId;
	    return $this;
	}
}
