<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Entity
{


	public $id;


	/**
	 * @return int 
	 */
	public function getId() {
	    return $this->id;
	}
	
	
	/**
	 * @param int $id 
	 */
	public function setId($id) {
	    $this->id = $id;
	    return $this;
	}


	/**
	 * consumes array on build for convinience
	 * @param array $array 
	 */
	public function __construct($array = [])
	{
		if (! $array) {
			return $this;
		}
		return $this->consumeArray($array);
	}


	/**
	 * takes the url object from the registry and passes back the
	 * absolute url for the website
	 * @return string 
	 */
	public function getUrlAbsolute()
	{
		$registry = OriginalAppName\Registry::getInstance();
		return $registry->get('url')->getCache('base');
	}


	public function getUrlGenerator()
	{
		$registry = \OriginalAppName\Registry::getInstance();
		return $registry->get('urlGenerator');
	}


	/**
	 * merges array key => values with that of the entity
	 * @param  array $array entity property -> value
	 * @return object        
	 */
	public function consumeArray($array)
	{
		foreach ($array as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (! method_exists($this, $method)) {
				continue;
			}
			$this->$method($value);
		}
		return $this;
	}
}
