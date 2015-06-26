<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Player extends \OriginalAppName\Site\Elttl\Model\Tennis
{	


	public $tableName = 'tennisPlayer';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Player';


	public $fields = array(
		'id',
		'yearId',
		'nameFirst',
		'nameLast',
		'slug',
		'rank',
		'phoneLandline',
		'phoneMobile',
		'ettaLicenseNumber',
		'teamId'
	);
}
