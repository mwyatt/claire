<?php

namespace OriginalAppName\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Test extends \OriginalAppName\Model
{	


	public $tableName = 'test';


	public $fields = [
		'id',
		'testKey',
		'testValue'
	];


	public $entity = '\\OriginalAppName\\Entity\\Test';
}
