<?php

namespace OriginalAppName\Model;


/**
 * responsible for various content types (projects, posts and pages)
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Menu extends \OriginalAppName\Model
{	


	public $tableName = 'menu';


	public $entity = '\\OriginalAppName\\Entity\\Menu';

	
	public $fields = [
		'id'
		, 'idParent'
		, 'name'
		, 'url'
		, 'keyGroup'
	];
}
