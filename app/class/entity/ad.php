<?php

namespace OriginalAppName\Entity;


/**
 * @todo finalise
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ad extends \OriginalAppName\Entity
{


	/**
	 * @var string
	 */
	private $title;


	/**
	 * @var string
	 */
	private $description;


	/**
	 * @var string
	 */
	private $image;

	
	/**
	 * @var string
	 */
	private $url;


	/**
	 * @var string
	 */
	private $action;


	private $group;


	/**
	 * @return string 
	 */
	public function getTitle() {
	    return $this->title;
	}
	
	
	/**
	 * @param string $title 
	 */
	public function setTitle($title) {
	    $this->title = $title;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getDescription() {
	    return $this->description;
	}
	
	
	/**
	 * @param string $description 
	 */
	public function setDescription($description) {
	    $this->description = $description;
	    return $this;
	}


	/**
	 * @return string
	 */
	public function getImage() {
	    return $this->image;
	}
	
	
	/**
	 * @param string $image 
	 */
	public function setImage($image) {
	    $this->image = $image;
	    return $this;
	}


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
}
