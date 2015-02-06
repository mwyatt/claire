<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Project extends \OriginalAppName\Entity\Content
{


	/**
	 * abs url to project
	 * @var string
	 */
	protected $url;


	/**
	 * @var string
	 */
	protected $descriptionShort;



	/**
	 * @return string 
	 */
	public function getLogo() {
	    return $this->logo;
	}
	
	
	/**
	 * @param string $logo 
	 */
	public function setLogo($logo) {
	    $this->logo = $logo;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getDescriptionShort() {
	    return $this->descriptionShort;
	}
	
	
	/**
	 * @param string $descriptionShort 
	 */
	public function setDescriptionShort($descriptionShort) {
	    $this->descriptionShort = $descriptionShort;
	    return $this;
	}
}
