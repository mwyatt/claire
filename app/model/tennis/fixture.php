<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Tennis_Fixture extends Model
{	


	public $fields = array(
		'id',
		'team_id_left',
		'team_id_right',
		'score_left',
		'score_right',
		'year_id'
	);
}
