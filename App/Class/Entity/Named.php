<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Named extends \OriginalAppName\Entity
{


	/**
	 * main title for the content
	 * @var string
	 */
	private $title;


	/**
	 * the type of content
	 * @var string
	 */
	private $type;




	
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
}
