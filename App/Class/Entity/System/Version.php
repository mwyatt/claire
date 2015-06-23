<?php

namespace OriginalAppName\Entity\System;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Version extends \OriginalAppName\Entity
{


	/**
	 * @var int
	 */
	public $id;


	/**
	 * eg 1.0.1
	 * @var string
	 */
	public $name;


	/**
	 * epoch
	 * @var int
	 */
	public $timePatched;


	/**
	 * @var int
	 */
	public $userId;
}
