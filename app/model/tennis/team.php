<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Tennis_Team extends Model
{	


	public $fields = array(
		'id',
		'division_id',
		'venue_id',
		'secretary_id',
		'name',
		'home_weekday'
	);
}
