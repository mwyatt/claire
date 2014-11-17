<?php

namespace OriginalAppName\Model;


/**
 * responsible for various content types (projects, posts and pages)
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Model
{	


	public $tableName = 'user';


	public $entity = '\\OriginalAppName\\Entity\\User';

	
	public $fields = array(
		'id'
		, 'email'
		, 'password'
		, 'nameFirst'
		, 'nameLast'
		, 'timeRegistered'
		, 'level'
	);
}
