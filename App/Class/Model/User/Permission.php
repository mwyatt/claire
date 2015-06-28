<?php

namespace OriginalAppName\Model\User;

use \PDO;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Permission extends \OriginalAppName\Model
{	


	public $tableName = 'userPermission';

	
	public $fields = [
		'id',
		'userId',
		'name'
	];


	public $entity = '\\OriginalAppName\\Entity\\User\\Permission';


	public function deleteUserId($userId)
	{
		$statement = [];
		$statement[] = 'delete from';
		$statement[] = $this->getTableName();
		$statement[] = 'where userId = ?';

		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// bind
	    $sth->bindValue(1, $userId, PDO::PARAM_INT);
		$sth->execute();

		// return
		$this->setRowCount($sth->rowCount());
        return $this;
	}
}
