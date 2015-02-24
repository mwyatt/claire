<?php

namespace OriginalAppName\Entity;


/**
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
	 * relative url to featured image / artwork
	 * @var string
	 */
	private $image;

	
	/**
	 * relative pointer to content
	 * @var string
	 */
	private $url;


	/**
	 * button which does something to confirm
	 * @var string
	 */
	private $action;


	/**
	 * ties together ads
	 * @var string
	 */
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
