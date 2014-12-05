<?php

namespace OriginalAppName\Model;


/**
 * responsible for various content types (projects, posts and pages)
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Project extends \OriginalAppName\Model\Content
{	


	public $tableName = 'project';


	public $entity = '\\OriginalAppName\\Entity\\Project';


	public $fields = array(
		'id',
		'descriptionShort',
		'url',
		'title',
		'slug',
		'html',
		'type',
		'timePublished',
		'status'
	);
}
