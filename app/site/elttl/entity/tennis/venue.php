<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Venue extends \OriginalAppName\Site\Elttl\Entity\Tennis\YearId
{


	private $name;


	private $location;


	/**
	 * @return string 
	 */
	public function getName() {
	    return $this->name;
	}
	
	
	/**
	 * @param string $name 
	 */
	public function setName($name) {
	    $this->name = $name;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getLocation() {
	    return $this->location;
	}
	
	
	/**
	 * @param int $location 
	 */
	public function setLocation($location) {
	    $this->location = $location;
	    return $this;
	}
}
