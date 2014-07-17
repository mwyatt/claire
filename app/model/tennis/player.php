<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Tennis_Player extends Model
{	


	public $fields = array(
		'id',
		'team_id',
		'name_first',
		'name_last',
		'rank',
		'phone_landline',
		'phone_mobile',
		'etta_license_number'
	);
}
