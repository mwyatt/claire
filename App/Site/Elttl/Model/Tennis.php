<?php

namespace OriginalAppName\Site\Elttl\Model;

use \PDO;
use OriginalAppName\Registry;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Tennis extends \OriginalAppName\Model
{


	/**
	 * take passed entities and create using even the id
	 * @param  array $entities 
	 * @return object           
	 */
	public function duplicate($entities)
	{

		// statement
		$statement = [];
		$lastInsertIds = [];
		$statement[] = 'insert into';
		$statement[] = $this->getTableName();
		$statement[] = '(' . $this->getSqlFields() . ')';
		$statement[] = 'values';
		$statement[] = '(' . $this->getSqlPositionalPlaceholders() . ')';

		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// execute
        foreach ($entities as $entity) {
			$sth->execute($this->getSthExecutePositional($entity));
			if ($sth->rowCount()) {
				$lastInsertIds[] = intval($this->database->dbh->lastInsertId());
			}
        }

		// return
		$this->setLastInsertIds($lastInsertIds);
		return $this;
	}


	/**
	 * @param  array $ids
	 * @return object
	 */
	public function readYearId($ids, $column = 'id')
	{
		$registry = Registry::getInstance();

		// query
		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where {$column} = :id
            and yearId = :yearId
		");
		$entity = $this->getEntity();

		// mode
		$sth->setFetchMode(PDO::FETCH_CLASS, $this->getEntity());
	    $sth->bindValue(':yearId', $registry->get('database/options/yearId'), PDO::PARAM_INT);

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


	/**
	 * reads where column == value
	 * @param  string $column table column
	 * @param  any $value  to match
	 * @return object         
	 */
	public function readYearColumn($column, $value)
	{
		$registry = Registry::getInstance();

		// query
		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where {$column} = :value and yearId = :yearId
		");

		// mode
		$sth->setFetchMode(PDO::FETCH_CLASS, $this->getEntity());
	    $this->bindValue($sth, ':value', $value);
    	$this->bindValue($sth, ':yearId', $registry->get('database/options/yearId'));
		$sth->execute();
		$this->setData($sth->fetchAll());

		// instance
		return $this;
	}


	/**
	 * uses where property to build delete statement
	 * @param  array  $properties 
	 * @return int             
	 */
	public function deleteYear($ids)
	{
		$registry = Registry::getInstance();

		// build
		$rowCount = 0;
		$statement = [];
		$statement[] = 'delete from';
		$statement[] = $this->getTableName();
		$statement[] = 'where id = ?';
		$statement[] = 'and yearId = ?';

		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// bind
		foreach ($ids as $id) {
		    $sth->bindValue(1, $id, PDO::PARAM_INT);
		    $sth->bindValue(2, $registry->get('database/options/yearId'), PDO::PARAM_INT);
			$sth->execute();
			$rowCount += $sth->rowCount();
		}

		// return
		$this->setRowCount($rowCount);
        return $this;
	}


	/**
	 * update multiple entities by year
	 * @param  array $entities 
	 * @return bool           true if same amount passed are updated
	 */
	public function updateYear($entities)
	{
		
		// statement
		$statement = [];
		$statement[] = 'update';
		$statement[] = $this->getTableName();
		$statement[] = 'set';
		$updateTotalExpected = count($entities);
		$updateTotalActual = 0;

		// col = :col
		$named = [];
		foreach ($this->getFields() as $field) {
			$named[] = $field . ' = :' . $field;
		}
		$statement[] = implode(', ', $named);

		// where
		$statement[] = 'where id = :id and yearId = :yearId';
		
		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// persist
		foreach ($entities as $entity) {
			foreach ($this->getSthExecuteNamed($entity) as $key => $value) {
				$this->bindValue($sth, $key, $value);
			}
			$sth->setFetchMode(PDO::FETCH_CLASS, $this->getEntity());
			$sth->execute();
			$updateTotalActual += $sth->rowCount();
		}

		// show results
		$this->setRowCount($updateTotalActual);
        return $updateTotalExpected == $updateTotalActual;
	}
}
