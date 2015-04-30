<?php

namespace OriginalAppName\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ad extends \OriginalAppName\Model
{	


	public $tableName = 'ad';

	
	public $fields = array(
		'id',
		'title',
		'description',
		'image',
		'url',
		'action',
		'group'
	);


	public $entity = '\\OriginalAppName\\Entity\\Ad';
}
