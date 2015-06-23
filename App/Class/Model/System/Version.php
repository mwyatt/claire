<?php

namespace OriginalAppName\Model\System;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Version extends \OriginalAppName\Model
{	


	public $tableName = 'systemVersion';

	
	public $fields = [
		'id',
		'name',
		'timePatched',
		'userId'
	];


	public $entity = '\\OriginalAppName\\Entity\\SystemVersion';
}
