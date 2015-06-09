<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;

use OriginalAppName\Registry;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Division extends \OriginalAppName\Model
{	


	public $tableName = 'tennisDivision';


	public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Division';


	public $fields = [
		'id',
		'yearId',
		'name'
	];


	public function read()
	{

		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where {$column} = :id
		");

		$entity = $this->getEntity();

		// mode
		$sth->setFetchMode(PDO::FETCH_CLASS, $this->getEntity());

		// loop prepared statement
		foreach ($ids as $id) {
		    $sth->bindValue(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			while ($result = $sth->fetch()) {
				$this->appendData($result);
			}
		}

		// instance
		return $this;
	}
}
