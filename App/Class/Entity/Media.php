<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Media extends OriginalAppName\Entity
{



	/**
	 * main title for the content
	 * @var string
	 */
	private $title;

	
	/**
	 * little description of the image
	 * @var string
	 */
	private $description;

	
	/**
	 * file path to the image
	 * @var string
	 */
	private $path;


	/**
	 * the type of content
	 * @var string
	 */
	private $type;


	/**
	 * possible type options
	 * @todo correct mimes?
	 * @var array
	 */
	private $typePossible = array(
		'png',
		'jpg'
	);


	/**
	 * epoch time of when the content was created
	 * @var int
	 */
	private $timePublished;


	/**
	 * the id of the user which created this content
	 * @var int
	 */
	private $userId;


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
	public function getPath() {
	    return $this->path;
	}
	
	
	/**
	 * @param string $path 
	 */
	public function setPath($path) {
	    $this->path = $path;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getType() {
	    return $this->type;
	}
	
	
	/**
	 * @param string $type 
	 */
	public function setType($type) {
		if (in_array($type, $this->getTypePossible())) {
		    $this->type = $type;
		}
	    return $this;
	}


	/**
	 * @return array 
	 */
	public function getTypePossible() {
	    return $this->typePossible;
	}
	
	
	/**
	 * @param array $typePossible 
	 */
	public function setTypePossible($typePossible) {
	    $this->typePossible = $typePossible;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getTimePublished() {
	    return $this->timePublished;
	}
	
	
	/**
	 * @param int $timePublished 
	 */
	public function setTimePublished($timePublished) {
	    $this->timePublished = $timePublished;
	    return $this;
	}


	/**
	 * @return int 7
	 */
	public function getUserId() {
	    return $this->userId;
	}
	
	
	/**
	 * @param int $userId 
	 */
	public function setUserId($userId) {
	    $this->userId = $userId;
	    return $this;
	}
}
