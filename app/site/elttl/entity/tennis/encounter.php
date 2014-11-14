<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Encounter extends \OriginalAppName\Site\Elttl\Entity\Tennis\YearId
{

	
	private $fixtureId;

	
	private $scoreLeft;

	
	private $scoreRight;

	
	private $playerIdLeft;

	
	private $playerIdRight;

	
	private $playerRankChangeLeft;

	
	private $playerRankChangeRight;

	
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
	    return $this->fixtureId;
	}
	
	
	/**
	 * @param int $fixtureId 
	 */
	public function setfixtureId($fixtureId) {
	    $this->fixtureId = $fixtureId;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getScoreLeft() {
	    return $this->scoreLeft;
	}
	
	
	/**
	 * @param int $scoreLeft 
	 */
	public function setScoreLeft($scoreLeft) {
	    $this->scoreLeft = $scoreLeft;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getScoreRight() {
	    return $this->scoreRight;
	}
	
	
	/**
	 * @param int $scoreRight 
	 */
	public function setScoreRight($scoreRight) {
	    $this->scoreRight = $scoreRight;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerIdLeft() {
	    return $this->playerIdLeft;
	}
	
	
	/**
	 * @param int $playerIdLeft 
	 */
	public function setPlayerIdLeft($playerIdLeft) {
	    $this->playerIdLeft = $playerIdLeft;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerIdRight() {
	    return $this->playerIdRight;
	}
	
	
	/**
	 * @param int $playerIdRight 
	 */
	public function setPlayerIdRight($playerIdRight) {
	    $this->playerIdRight = $playerIdRight;
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
	    return $this->playerRankChangeLeft;
	}
	
	
	/**
	 * @param int $playerRankChangeLeft 
	 */
	public function setPlayerRankChangeLeft($playerRankChangeLeft) {
	    $this->playerRankChangeLeft = $playerRankChangeLeft;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPlayerRankChangeRight() {
	    return $this->playerRankChangeRight;
	}
	
	
	/**
	 * @param int $playerRankChangeRight 
	 */
	public function setPlayerRankChangeRight($playerRankChangeRight) {
	    $this->playerRankChangeRight = $playerRankChangeRight;
	    return $this;
	}
}
