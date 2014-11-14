<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * used only to extend this common column
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class YearId extends \OriginalAppName\Entity
{


	private $yearId;


	/**
	 * @return int 
	 */
	public function getYearId() {
	    return $this->yearId;
	}
	
	
	/**
	 * @param int $yearId 
	 */
	public function setYearId($yearId) {
	    $this->yearId = $yearId;
	    return $this;
	}
}
