<?php

/*
CREATE TABLE dummy (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`logo` VARCHAR(150) NOT NULL DEFAULT '',
	`url` VARCHAR(150) NOT NULL DEFAULT '',
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`slug` VARCHAR(255) NOT NULL,
	`descriptionShort` VARCHAR(255) NOT NULL DEFAULT '',
	`html` LONGTEXT NULL,
	`type` VARCHAR(50) NOT NULL DEFAULT '',
	`timePublished` INT(10) UNSIGNED NULL DEFAULT '0',
	`status` VARCHAR(50) NOT NULL DEFAULT 'hidden'
)
 */

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
	private $url;


	/**
	 * rel path to logo
	 * @var string
	 */
	private $logo;


	/**
	 * @var string
	 */
	private $descriptionShort;


	/**
	 * @return string 
	 */
	public function getUrl() {
	    return $this->url;
	}
	
	
	/**
	 * @param string $url 
	 */
	public function setUrl($url) {
	    $this->url = $url;
	    return $this;
	}


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
