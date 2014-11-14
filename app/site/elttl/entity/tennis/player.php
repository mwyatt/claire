<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Player extends \OriginalAppName\Site\Elttl\Entity\Tennis\YearId
{

	
	private $yearId;


	private $teamId;

	
	private $nameFirst;

	
	private $nameLast;

	
	private $rank;

	
	private $phoneLandline;

	
	private $phoneMobile;

	
	private $ettaLicenseNumber;


	/**
	 * @return int 
	 */
	public function getTeamId() {
	    return $this->teamId;
	}
	
	
	/**
	 * @param int $teamId 
	 */
	public function setTeamId($teamId) {
	    $this->teamId = $teamId;
	    return $this;
	}


	/**
	 * first and last name combined with a space
	 * @return string 
	 */
	public function getNameFull() {
	    return $this->nameFirst . ' ' . $this->nameLast;
	}


	/**
	 * @return string 
	 */
	public function getNameFirst() {
	    return $this->nameFirst;
	}
	
	
	/**
	 * @param string $nameFirst 
	 */
	public function setNameFirst($nameFirst) {
	    $this->nameFirst = $nameFirst;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getNameLast() {
	    return $this->nameLast;
	}
	
	
	/**
	 * @param string $nameLast 
	 */
	public function setNameLast($nameLast) {
	    $this->nameLast = $nameLast;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getRank() {
	    return $this->rank;
	}


	/**
	 * even if the number is negative you add them together and the
	 * subtraction is made
	 * remember testing wont work as you keep getting new val
	 * @param  int $modifier
	 * @return null        
	 */
	public function modifyRank($modifier, $reverse = false)
	{
		// echo '<pre>';
		// printR(['current' => $this->getRank(), 'change' => $modifier]);
		if ($reverse) {
			$this->setRank($this->getRank() - $modifier);
			// printR(['new' => $this->getRank() - $modifier]);
		} else {
			$this->setRank($this->getRank() + $modifier);
			// printR(['new' => $this->getRank() + $modifier]);
		}
		// echo '</pre>';
	}

	
	/**
	 * @param int $rank 
	 */
	public function setRank($rank) {
	    $this->rank = $rank;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPhoneLandline() {
	    return $this->phoneLandline;
	}
	
	
	/**
	 * @param int $phoneLandline 
	 */
	public function setPhoneLandline($phoneLandline) {
	    $this->phoneLandline = $phoneLandline;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPhoneMobile() {
	    return $this->phoneMobile;
	}
	
	
	/**
	 * @param int $phoneMobile 
	 */
	public function setPhoneMobile($phoneMobile) {
	    $this->phoneMobile = $phoneMobile;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getEttaLicenseNumber() {
	    return $this->ettaLicenseNumber;
	}
	
	
	/**
	 * @param int $ettaLicenseNumber 
	 */
	public function setEttaLicenseNumber($ettaLicenseNumber) {
	    $this->ettaLicenseNumber = $ettaLicenseNumber;
	    return $this;
	}


	/**
	 * untested example of how the url could be built using a constant
	 * registry pattern perhaps?
	 * @return string url
	 */
	public function getUrl()
	{
		return implode('/', array(URLABSOLUTE, 'player', Helper::slugify($this->getNameFull())));
	}
}
