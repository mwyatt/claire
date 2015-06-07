<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Player extends \OriginalAppName\Entity
{

	
	public $id;


	public $yearId;

	
	public $nameFirst;

	
	public $nameLast;


	public $slug;

	
	public $rank;

	
	public $phoneLandline;

	
	public $phoneMobile;

	
	public $ettaLicenseNumber;


	public $teamId;


	/**
	 * first and last name combined with a space
	 * @return string 
	 */
	public function getNameFull() {
	    return $this->nameFirst . ' ' . $this->nameLast;
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
}
