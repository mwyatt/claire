<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Model extends \OriginalAppName\Data
{


	/**
	 * the table being read
	 * @var string
	 */
	public $tableName;


	/**
	 * comprehensive list of database fields for use when building queries
	 * @var array
	 */
	public $fields = [];


	/**
	 * used to reduce fields to writable ones
	 * for update, create
	 * @var array
	 */
	public $fieldsNonWriteable = [
		'id'
	];


	/**
	 * inject dependencies
	 * database
	 */
	public function __construct() {
		$registry = \OriginalAppName\Registry::getInstance();
		if (! $database = $registry->get('database')) {
			throw new Exception('OriginalAppName\\Model::__construct, missing dependency database');
		}
		$this->setDatabase($database);
	}


	/**
	 * @return string 
	 */
	public function getEntity() {
	    return $this->entity;
	}
	
	
	/**
	 * @param string $entity 
	 */
	public function setEntity($entity) {
	    $this->entity = $entity;
	    return $this;
	}


	/**
	 * @return array 
	 */
	public function getFields() {
	    return $this->fields;
	}
	
	
	/**
	 * @param array $fields 
	 */
	public function setFields($fields) {
	    $this->fields = $fields;
	    return $this;
	}


	/**
	 * global read for ids
	 * extend this if more detail required
	 * @param  array $ids
	 * @return object
	 */
	public function readId($ids, $column = 'id')
	{

		// query
		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where {$column} = :id
		");

		// mode
		$sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

		// loop prepared statement
		foreach ($ids as $id) {
		    $sth->bindValue(':id', $id, \PDO::PARAM_INT);
			$sth->execute();
			$this->appendData($sth->fetch());
		}

		// instance
		return $this;
	}


	/**
	 * @param  array $molds 
	 * @return array 	of insert ids
	 */
	public function create($molds = array())
	{

		// statement
		$statement = array();
		$lastInsertIds = array();
		$statement[] = 'insert into';
		$statement[] = $this->getIdentity();
		$statement[] = '(' . $this->getSqlFieldsWriteable() . ')';
		$statement[] = 'values';
		$statement[] = '(' . $this->getSqlPositionalPlaceholders() . ')';

		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// execute
        foreach ($molds as $mold) {
			$this->tryExecute(__METHOD__, $sth, $this->getSthExecutePositional($mold));
			if ($sth->rowCount()) {
				$lastInsertIds[] = intval($this->database->dbh->lastInsertId());
			}
        }

		// return
		return $lastInsertIds;
	}	


	/**
	 * reads everything
	 * @return object 
	 */
	public function read()
	{

		// query
		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
	        where id != 0
		");

		// mode
		$sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

	    // execute
		$sth->execute();

		// fetch
		$this->setData($sth->fetchAll());

		// instance
		return $this;
	}


	/**
	 * uses the passes properties to build named prepared statement
	 * @todo how to return a value which can mark success?
	 * @param  array  $molds 
	 * @param  string $by    defines the column to update by
	 * @return int        
	 */
	public function update($mold, $properties = array())
	{

		// statement
		$statement = array();
		$statement[] = 'update';
		$statement[] = $this->getIdentity();
		$statement[] = 'set';

		// must be writable columns
		$named = array();
		foreach ($mold as $key => $value) {
			if (in_array($key, $this->fieldsNonWriteable)) {
				continue;
			}
			$named[] = $key . ' = :' . $key;
		}
		$statement[] = implode(', ', $named);
		if (array_key_exists('where', $properties)) {
			$statement[] = $this->getSqlWhere($properties['where']);
		}

		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// bind
		if (array_key_exists('where', $properties)) {
			foreach ($properties['where'] as $key => $value) {
				$this->bindValue($sth, 'where_' . $key, $value);
			}
		}
		foreach ($this->getSthExecuteNamed($mold) as $key => $value) {
			$this->bindValue($sth, $key, $value);
		}

		// execute
		$this->tryExecute(__METHOD__, $sth);

		// return
        return $sth->rowCount();
	}


	/**
	 * uses where property to build delete statement
	 * @param  array  $properties 
	 * @return int             
	 */
	public function delete($properties = array())
	{

		// build
		$statement = array();
		$statement[] = 'delete from';
		$statement[] = $this->getIdentity();
		if (array_key_exists('where', $properties)) {
			$statement[] = $this->getSqlWhere($properties['where']);
		}

		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// bind
		if (array_key_exists('where', $properties)) {
			foreach ($properties['where'] as $key => $value) {
				$this->bindValue($sth, 'where_' . $key, $value);
			}
		}

		// execute
		$this->tryExecute(__METHOD__, $sth);
		return $sth->rowCount();
	}


	/**
	 * builds a generic select statement and returns
	 * select (column, column) from (table_name)
	 * @return string 
	 */
	public function getSqlSelect()
	{
		$statement = array();
		$statement[] = 'select';
		$statement[] = $this->getSqlFields();
		$statement[] = 'from';
		$statement[] = $this->getTableName();
		return implode(' ', $statement);
	}


	/**
	 * implodes list of sql fields
	 * column, column, column
	 * @return string 
	 */
	public function getSqlFields()
	{
		return implode(', ', $this->fields);
	}


	/**
	 * implodes list of sql fields excluding fields like 'id'
	 * column, column, column
	 * @return string 
	 */ 
	public function getSqlFieldsWriteable($append = '')
	{
		$writeable = array();
		foreach ($this->fields as $field) {
			if (in_array($field, $this->fieldsNonWriteable)) {
				continue;
			}
			$writeable[] = $field . $append;
		}
		return implode(', ', $writeable);
	}


	/**
	 * @return string ?, ?, ? of all writable fields
	 */
	public function getSqlPositionalPlaceholders()
	{
		$placeholders = array();
		foreach ($this->fields as $field) {
			if (in_array($field, $this->fieldsNonWriteable)) {
				continue;
			}
			$placeholders[] = '?';
		}
		return implode(', ', $placeholders);
	}


	public function isFieldNonWritable($field)
	{
		return in_array($field, $this->fieldsNonWriteable);
	}


	/**
	 * uses a mold to build sth execute data
	 * if 'time' involved assume that time needs to be inserted, could be
	 * a bad idea
	 * @param  object $mold instance of mold
	 * @return array       
	 */
	public function getSthExecutePositional($mold)
	{
		$excecuteData = array();
		foreach ($this->fields as $field) {
			if ($this->isFieldNonWritable($field)) {
				continue;
			}
			$excecuteData[] = $mold->$field;
		}
		return $excecuteData;
	}


	public function getSthExecuteNamed($mold)
	{
		$excecuteData = array();
		foreach ($mold as $key => $value) {
			if ($this->isFieldNonWritable($key)) {
				continue;
			}
			$excecuteData[':' . $key] = $value;
		}
		return $excecuteData;
	}


	/**
	 * builds sql where string using and
	 * @param  array  $where accepts ('column' => 'value') format
	 * @return string        
	 */
	public function getSqlWhere($where = array())
	{
		$statement = array();
		foreach ($where as $key => $value) {
			$statement[] = ($statement ? 'and' : 'where');

			// array becomes in (1, 2, 3)
			if (is_array($value)) {
				$statement[] = $key . ' in (' . implode(', ', $value) . ')';
				continue;
			}

			// normal key = val
			$statement[] = $key . ' = :where_' . $key;
		}
		return implode(' ', $statement);
	}


	/**
	 * builds sql limit using array
	 * @param  array  $limit accepts ('key' => 'value', 'key' => 'value')
	 * @return string        
	 */
	public function getSqlLimit($limit = array())
	{
		$statement = array();
		$limits = array();
		$statement[] = 'limit';
		foreach ($limit as $key => $value) {
			$limits[] = ':limit_' . $key;
		}
		$statement[] = implode(', ', $limits);
		return implode(' ', $statement);
	}


	/**
	 * @return string 
	 */
	public function getTableName() {
	    return $this->tableName;
	}
	
	
	/**
	 * @param string $tableName 
	 */
	public function setTableName($tableName) {
	    $this->tableName = $tableName;
	    return $this;
	}


	/**
	 * move elsewhere
	 * @param  string $side 
	 * @return string       
	 */
	public function getOtherSide($side = '')
	{
		if ($side == 'left') {
			return 'right';
		}
		return 'left';
	}


	/**
	 * order by a property
	 * @todo try and make more readable
	 * @param  string $property database table column name
	 * @param  string $order    asc|desc
	 * @return object           
	 */
	public function orderByProperty($property, $order = 'asc')
	{
		$data = $this->getData();
		$dataSingle = current($data);
		$method = 'get' . ucfirst($property);
		if (! method_exists($dataSingle, $method)) {
			return;
		}
		$sampleValue = $dataSingle->$method();
		if (is_string($sampleValue)) {
			$type = 'string';
		}
		if (is_int($sampleValue)) {
			$type = 'integer';
		}

		// sort
		uasort($data, function($a, $b) use ($method, $type, $order) {
			if ($type == 'string') {
				if ($order == 'asc') {
					return strcasecmp($a->$method(), $b->$method());
				} else {
					return strcasecmp($b->$method(), $a->$method());
				}
			}
			if ($type == 'integer') {
				if ($order = 'asc') {
					if ($a->$method() == $b->$method()) {
						return 0;
					}
					return $a->$method() < $b->$method() ? -1 : 1;
				} else {
					if ($a->$method() == $b->$method()) {
						return 0;
					}
					return $a->$method() > $b->$method() ? -1 : 1;
				}
			}

		});
		$this->setData($data);
		return $this;
	}


	// public function orderByPropertyStringAsc($property)
	// {
	// 	$data = $this->getData();

	// 	// fail silent
	// 	$dataSample = current($data);
	// 	if (! property_exists($dataSample, $property)) {
	// 		return;
	// 	}

	// 	// sort
	// 	uasort($data, function($a, $b) use ($property) {
	// 		return strcasecmp($a->$property, $b->$property);
	// 	});
	// 	$this->setData($data);
	// 	return $this;
	// }


	// public function orderByPropertyStringDesc($property)
	// {
	// 	$data = $this->getData();

	// 	// fail silent
	// 	$dataSample = current($data);
	// 	if (! property_exists($dataSample, $property)) {
	// 		return;
	// 	}

	// 	// sort
	// 	uasort($data, function($a, $b) use ($property) {
	// 		return strcasecmp($b->$property, $a->$property);
	// 	});
	// 	$this->setData($data);
	// 	return $this;
	// }


	// public function orderByPropertyIntAsc($property)
	// {
	// 	if (! $data = $this->getData()) {
	// 		return $this;
	// 	}

	// 	// fail silent
	// 	$dataSample = current($data);
	// 	if (! property_exists($dataSample, $property)) {
	// 		return $this;
	// 	}

	// 	// sort
	// 	uasort($data, function($a, $b) use ($property) {
	// 		if ($a->$property == $b->$property) {
	// 			return 0;
	// 		}
	// 		return $a->$property < $b->$property ? -1 : 1;
	// 	});
	// 	$this->setData($data);
	// 	return $this;
	// }


	// public function orderByPropertyIntDesc($property)
	// {
	// 	if (! $data = $this->getData()) {
	// 		return $this;
	// 	}

	// 	// fail silent
	// 	$dataSample = current($data);
	// 	if (! property_exists($dataSample, $property)) {
	// 		return $this;
	// 	}

	// 	// sort
	// 	uasort($data, function($a, $b) use ($property) {
	// 		if ($a->$property == $b->$property) {
	// 			return 0;
	// 		}
	// 		return $a->$property > $b->$property ? -1 : 1;
	// 	});
	// 	$this->setData($data);
	// 	return $this;
	// }


	/**
	 * binds values with unnamed placeholders, 1 2 3 instead of 0 1 2
	 * @param  object $sth    the statement to bind to
	 * @param  array $values basic array with values
	 * @return bool | null         returns false if something goes wrong
	 */
	public function bindValues($sth, $values)
	{
	    if (! is_object($sth) || ! ($sth instanceof PDOStatement)) {
	    	return;
	    }
        foreach($values as $key => $value) {
        	$correctedKey = $key + 1;
        	$this->bindValue($sth, $correctedKey, $value);
        }
	}


	/**
	 * binds a single value and guesses the type
	 * @param  object $sth   
	 * @param  int|string $key   
	 * @param  all $value 
	 */
	public function bindValue($sth, $key, $value)
	{
		if (is_int($value)) {
		    $sth->bindValue($key, $value, PDO::PARAM_INT);
		} elseif (is_bool($value)) {
		    $sth->bindValue($key, $value, PDO::PARAM_BOOL);
		} elseif (is_null($value)) {
		    $sth->bindValue($key, $value, PDO::PARAM_NULL);
		} elseif (is_string($value)) {
		    $sth->bindValue($key, $value, PDO::PARAM_STR);
		}
	}


	/**
	 * attempts to execute, if problem found error code is shown
	 * @param  object $sth       
	 * @param  string $errorCode 
	 * @return object           
	 */
	public function tryExecute($errorCode, $sth, $sthData = array())
	{
		try {
			if ($sthData) {
				$sth->execute($sthData);
			} else {
				$sth->execute();
			}
		} catch (Exception $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
			exit;
			
			echo '<pre>';
			print_r($sthData);
			echo '</pre>';
			exit('error trying to execute statement');
			// $this->config->getObject('error')->handle('database', $errorCode, 'model.php', 'na');
			return false;
		}
		return $sth;
	}
}
