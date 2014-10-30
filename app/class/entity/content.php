<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends OriginalAppName\Entity
{


	private $title;


	private $slug;

	
	private $html;

	
	private $type;

	
	private $time_published;

	
	private $status;


	/**
	 * possible status options
	 * @var array
	 */
	private $statusPossible = array(
		'visible',
		'draft',
		'hidden'
	);
	

	private $user_id;


	/**
	 * @var object
	 */
	private $user;


	private $tag = array();


	private $media = array();


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
