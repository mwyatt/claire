<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="ad")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ad extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
     * @Column(type="string")
	 * @var string
	 */
	private $title;


	/**
     * @Column(type="string")
	 * @var string
	 */
	private $description;


	/**
	 * relative url to featured image / artwork
     * @Column(type="string")
	 * @var string
	 */
	private $image;

	
	/**
	 * relative pointer to content
     * @Column(type="string")
	 * @var string
	 */
	private $url;


	/**
	 * button which does something to confirm
     * @Column(type="string", length=50)
	 * @var string
	 */
	private $action;


	/**
	 * ties together ads
     * @Column(type="50")
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
