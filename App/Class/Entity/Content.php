<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Entity
{


	/**
	 * main title for the content
	 * @var string
	 */
	protected $title;


	/**
	 * foo-bar seperated title, for url
	 * @var string
	 */
	protected $slug;


	/**
	 * raw html code for the body of the content
	 * @var string
	 */
	protected $html;

	
	/**
	 * the type of content
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
	 * @var int
	 */
	protected $timePublished;

	
	/**
	 * status of the content
	 * @var string
	 */
	protected $status;


	/**
	 * collection of simple meta keys and values
	 * @var array foo => bar
	 */
	protected $meta;
	

	/**
	 * possible status options
	 * @var array
	 */
	protected $statusPossible = array(
		'visible',
		'draft',
		'hidden'
	);


	/**
	 * unpublished should not be shown on frontend
	 */
	const STATUS_UNPUBLISHED = 0;


	/**
	 * published should be visible to the world!
	 */
	const STATUS_PUBLISHED = 1;


	/**
	 * the id of the user which created this content
	 * @var int
	 */
	protected $userId;



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
	 * example.com/type/slug/
	 * @return string url
	 */
	public function getUrl()
	{
		$generator = $this->getUrlGenerator();
		return $generator->generate(
			'contentSingle',
			[
				'type' => $this->getType(),
				'slug' => $this->getSlug()
			],
			true
		);
	}


	/**
	 * example.com/admin/content/?id=22
	 * @return string url
	 */
	public function getUrlAdmin()
	{
		return implode('/', [
			$this->getUrlAbsolute(),
			'admin',
			'content?id=' . $this->getId()
		]);
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
}