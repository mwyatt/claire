<?php

/**
 * Cache
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Cache
{


	/**
	 * list of allowed templates which should be cached
	 * @var array
	 */
	public $templates = array('player', 'team', 'performance');
	

	/**
	 * check to see if the template is cached
	 * @param  string  $templateTitle 
	 * @return boolean                
	 */
	public function check($templateTitle) {
		if (in_array($templateTitle, $this->templates)) {
			return true;
		}
		return false;
	}

	
} 