<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="content")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
	 * main title for the content
     * @Column(type="string")
	 * @var string
	 */
	protected $title;


	/**
	 * foo-bar seperated title, for url
     * @Column(type="string")
	 * @var string
	 */
	protected $slug;


	/**
	 * raw html code for the body of the content
     * @Column(type="text")
	 * @var string
	 */
	protected $html;

	
	/**
	 * the type of content
     * @Column(type="string", length=50)
	 * @var string
	 */
	protected $type;


	/**
	 * possible type options
	 * @var array
	 */
	protected $typePossible = array(
		'post',
		'page'
	);

	
	/**
	 * epoch time of when the content was created
     * @Column(type="integer")
	 * @var int
	 */
	protected $timePublished;

	
	/**
	 * status of the content
     * @Column(type="integer")
	 * @var string
	 */
	protected $status;


	/**
	 * collection of simple meta keys and values
	 * @var array foo => bar
	 */
	protected $meta;
	

	/**
	 * content which is not ready for publishing
	 */
	const STATUS_UNPUBLISHED = 0;
	

	/**
	 * content which is ready to be seen
	 */
	const STATUS_PUBLISHED = 1;


	/**
	 * the id of the user which created this content
     * @Column(type="integer")
	 * @var int
	 */
	protected $userId;


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
	public function getHtml() {
	    return $this->html;
	}
	
	
	/**
	 * @param string $html 
	 */
	public function setHtml($html) {
	    $this->html = $html;
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
	    $this->type = $type;
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
	 * @return int 
	 */
	public function getStatus() {
	    return $this->status;
	}
	
	
	/**
	 * @param int $status 
	 */
	public function setStatus($status) {
	    $this->status = $status;
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


	/**
	 * @return array 
	 */
	public function getMeta() {
	    return $this->meta;
	}
	
	
	/**
	 * @param array $meta 
	 */
	public function setMeta($meta) {
	    $this->meta = $meta;
	    return $this;
	}


	/**
	 * destructively sets a single meta key
	 * @param string
	 * @param all
	 */
	public function setMetaKey($key, $value)
	{
		$this->meta[$key] = $value;
	}


	/**
	 * grab single meta key
	 * @param  string
	 * @return any false on failure
	 */
	public function getMetaKey($key)
	{
		return isset($this->meta[$key]) ? $this->meta[$key] : false;
	}


	public function getStatusText()
	{
	    $statuses = self::getStatuses();
	    return isset($statuses[$this->getStatus()]) ? $statuses[$this->getStatus()] : 'Unknown';
	}


	public static function getStatuses()
	{
	    return [
	        self::STATUS_UNPUBLISHED => 'Unpublished',
	        self::STATUS_PUBLISHED   => 'Published'
	    ];
	}
}
