<?php

namespace OriginalAppName\Entity\User;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Permission extends \OriginalAppName\Entity
{


	/**
	 * @var int
	 */
	public $id;


	/**
	 * @var int
	 */
	public $userId;


	/**
	 * foo/bar
	 * route of the permission
	 * @var string
	 */
	public $name;
}
