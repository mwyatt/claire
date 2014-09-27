<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Content extends Mold
{


	public $title;


	public $slug;

	
	public $html;

	
	public $type;

	
	public $time_published;

	
	public $status;


	/**
	 * possible status options
	 * @var array
	 */
	public $statusPossible = array(
		'visible',
		'draft',
		'hidden'
	);
	

	public $user_id;


	/**
	 * @var object
	 */
	public $user;


	public $tag = array();


	public $media = array();


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
	 * @return string foo-bar
	 */
	public function getSlug() {
	    return $this->slug;
	}
	
	
	/**
	 * @param string $slug Foo-bar
	 */
	public function setSlug($slug) {
	    $this->slug = $slug;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getStatus() {
	    return $this->status;
	}
	
	
	/**
	 * refers to statusPossible to ensure this status can be done
	 * otherwise it is not changed
	 * @param string $status 
	 */
	public function setStatus($status) {
		if (in_array($status, $this->getStatusPossible())) {
		    $this->status = $status;
		}
	    return $this;
	}


	/**
	 * @return array 
	 */
	public function getStatusPossible() {
	    return $this->statusPossible;
	}
	
	
	/**
	 * @param array $statusPossible 
	 */
	public function setStatusPossible($statusPossible) {
	    $this->statusPossible = $statusPossible;
	    return $this;
	}
}
