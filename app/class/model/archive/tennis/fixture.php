<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Archive_Tennis_Fixture extends Model_Tennis_Fixture
{	


	public $fields = array(
		'id',
		'year_id',
		'team_id_left',
		'team_id_right',
		'time_fulfilled'
	);
}
