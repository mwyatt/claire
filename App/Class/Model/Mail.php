<?php

namespace OriginalAppName\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mail extends \OriginalAppName\Model
{	


	public $tableName = 'mail';


	public $entity = '\\OriginalAppName\\Entity\\Mail';


	public $fields = array(
		'to',
		'from',
		'subject',
		'content',
		'timeSent'
	);
}
