<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Tennis_Encounter extends Model
{	


	public $fields = array(
		'id',
		'score_left',
		'score_right',
		'player_id_left',
		'player_id_right',
		'player_rank_change_left',
		'player_rank_change_right',
		'status'
	);
}
