<?php

namespace OriginalAppName\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Log extends \OriginalAppName\Model
{	


	public $tableName = 'log';


	public $fields = [
		'id',
		'message',
		'time',
		'type',
		'userId'
	];


	public $entity = '\\OriginalAppName\\Entity\\Log';


	public $types = [
		'admin'
	];


	/**
	 * utilises model create to make row
	 * @param  string $type    
	 * @param  string $message 
	 * @return int          
	 */
	public function log($type, $message)
	{
		$mold = new mold_log();
		$mold->message = $message;
		$mold->type = $type;
		$mold->time = time();
		if (! $ids = $this->create(array($mold))) {
			return;
		}
		if ($type == 'admin') {
			// $this->adminUnseen($ids);
		}
	}


	/**
	 * generate unseen rows
	 * @param  array $ids newly created log ids
	 * @return null      
	 */
	public function adminUnseen($logIds)
	{
		$modelLogAdminUnseen = new model_log_admin_unseen($this);
		$modelUser = new model_user($this);
		$moldLogAdminUnseen = new mold_log_admin_unseen();
		$molds = array();
		foreach ($logIds as $logId) {
			foreach ($modelUser->read() as $moldUser) {
				$moldLogAdminUnseen->log_id = $logId;
				$moldLogAdminUnseen->user_id = $moldUser->id;
				$molds[] = $moldLogAdminUnseen;
			}
		}
		$modelLogAdminUnseen->create($molds);
	}
}
