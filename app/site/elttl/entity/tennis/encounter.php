<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Tennis_Encounter extends OriginalAppName\Entity
{

	
	private $fixture_id;

	
	private $score_left;

	
	private $score_right;

	
	private $player_id_left;

	
	private $player_id_right;

	
	private $player_rank_change_left;

	
	private $player_rank_change_right;

	
	/**
	 * possible values
	 * doubles
	 * exclude
	 * @var string
	 */
	private $status;


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


	/**
	 * @return int 
	 */
	public function getScoreLeft() {
	    return $this->score_left;
	}
	
	
	/**
	 * @param int $scoreLeft 
	 */
	public function setScoreLeft($scoreLeft) {
	    $this->score_left = $scoreLeft;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getScoreRight() {
	    return $this->score_right;
	}
	
	
	/**
	 * @param int $scoreRight 
	 */
	public function setScoreRight($scoreRight) {
	    $this->score_right = $scoreRight;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerIdLeft() {
	    return $this->player_id_left;
	}
	
	
	/**
	 * @param int $playerIdLeft 
	 */
	public function setPlayerIdLeft($playerIdLeft) {
	    $this->player_id_left = $playerIdLeft;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerIdRight() {
	    return $this->player_id_right;
	}
	
	
	/**
	 * @param int $playerIdRight 
	 */
	public function setPlayerIdRight($playerIdRight) {
	    $this->player_id_right = $playerIdRight;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getStatus() {
	    return $this->status;
	}
	
	
	/**
	 * @param string $status 
	 */
	public function setStatus($status) {
	    $this->status = $status;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerRankChangeLeft() {
	    return $this->player_rank_change_left;
	}
	
	
	/**
	 * @param int $player_rank_change_left 
	 */
	public function setPlayerRankChangeLeft($playerRankChangeLeft) {
	    $this->player_rank_change_left = $playerRankChangeLeft;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerRankChangeRight() {
	    return $this->player_rank_change_right;
	}
	
	
	/**
	 * @param int $player_rank_change_right 
	 */
	public function setPlayerRankChangeRight($playerRankChangeRight) {
	    $this->player_rank_change_right = $playerRankChangeRight;
	    return $this;
	}
}
