<?php

namespace OriginalAppName\Model\User;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Permission extends \OriginalAppName\Model
{	


	public $tableName = 'userPermission';

	
	public $fields = [
		'id',
		'userId',
		'name'
	];


	public $entity = '\\OriginalAppName\\Entity\\User\\Permission';
}
