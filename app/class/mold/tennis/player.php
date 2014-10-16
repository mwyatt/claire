<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Tennis_Player extends Mold
{

	
	public $team_id;

	
	public $name_first;

	
	public $name_last;

	
	public $rank;

	
	public $phone_landline;

	
	public $phone_mobile;

	
	public $etta_license_number;


	/**
	 * @return int 
	 */
	public function getTeamId() {
	    return $this->team_id;
	}
	
	
	/**
	 * @param int $team_id 
	 */
	public function setTeamId($team_id) {
	    $this->team_id = $team_id;
	    return $this;
	}


	/**
	 * first and last name combined with a space
	 * @return string 
	 */
	public function getNameFull() {
	    return $this->name_first . ' ' . $this->name_last;
	}


	/**
	 * @return string 
	 */
	public function getNameFirst() {
	    return $this->name_first;
	}
	
	
	/**
	 * @param string $nameFirst 
	 */
	public function setNameFirst($nameFirst) {
	    $this->name_first = $nameFirst;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getNameLast() {
	    return $this->name_last;
	}
	
	
	/**
	 * @param string $nameLast 
	 */
	public function setNameLast($nameLast) {
	    $this->name_last = $nameLast;
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
		// print_r(['current' => $this->getRank(), 'change' => $modifier]);
		if ($reverse) {
			$this->setRank($this->getRank() - $modifier);
			// print_r(['new' => $this->getRank() - $modifier]);
		} else {
			$this->setRank($this->getRank() + $modifier);
			// print_r(['new' => $this->getRank() + $modifier]);
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
	    return $this->phone_landline;
	}
	
	
	/**
	 * @param int $phoneLandline 
	 */
	public function setPhoneLandline($phoneLandline) {
	    $this->phone_landline = $phoneLandline;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getPhoneMobile() {
	    return $this->phone_mobile;
	}
	
	
	/**
	 * @param int $phoneMobile 
	 */
	public function setPhoneMobile($phoneMobile) {
	    $this->phone_mobile = $phoneMobile;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getEttaLicenseNumber() {
	    return $this->etta_license_number;
	}
	
	
	/**
	 * @param int $ettaLicenseNumber 
	 */
	public function setEttaLicenseNumber($ettaLicenseNumber) {
	    $this->etta_license_number = $ettaLicenseNumber;
	    return $this;
	}


	/**
	 * untested example of how the url could be built using a constant
	 * registry pattern perhaps?
	 * @return string url
	 */
	public function getUrl()
	{
		return implode('/', array(URL_ABSOLUTE, 'player', $this->slugify($this->getNameFull())));
	}
}
