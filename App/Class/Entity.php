<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Entity
{


	/**
	 * does this belong here?
	 * @return int 
	 */
	public function getId() {
	    return $this->id;
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
