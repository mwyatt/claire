<?php

namespace OriginalAppName\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mail extends \OriginalAppName\Model
{	


	public $tableName = 'mail';


	public $fields = [
		'id',
		'to',
		'from',
		'subject',
		'body',
		'timeSent'
	];


	public $entity = '\\OriginalAppName\\Entity\\Mail';
	

	/**
	 * performs create and update
	 * @param  array $entities 
	 * @return array 	of insert ids
	 */
	public function save($entities)
	{

		$create = true;

		// determine if create or update first
		$entitySample = current($entity);
		if ($entitySample->getId()) {
			$create = false;
		}

		// init statement
		// if its update then it needs where id = ?
		// prepare the statment
		// run through the ents and perform
		// collect the last affected / created ids
		// pass back
		// 

		// statement
		$statement = [];
		$lastInsertIds = [];
		$statement[] = 'insert into';
		$statement[] = $this->getTableName();
		$statement[] = '(' . $this->getSqlFieldsWriteable() . ')';
		$statement[] = 'values';
		$statement[] = '(' . $this->getSqlPositionalPlaceholders() . ')';


		$placeholders = array();
		foreach ($this->fields as $field) {
			if (in_array($field, $this->fieldsNonWriteable)) {
				continue;
			}
			$placeholders[] = '?';
		}
		return implode(', ', $placeholders);



		// prepare
		$sth = $this->database->dbh->prepare(implode(' ', $statement));

		// execute
        foreach ($entities as $entity) {

        	$excecuteData = array();
        	foreach ($this->fields as $field) {
        		$method = 'get' . ucfirst($field);
        		if ($this->isFieldNonWritable($field)) {
        			continue;
        		}
        		$excecuteData[] = $entity->$method();
        	}
        	return $excecuteData;



        	echo '<pre>';
        	print_r($entity);
        	echo '</pre>';
        	// exit;
        	
        	$entity->beforeSave();
echo '<pre>';
print_r($entity);
echo '</pre>';
// exit;

        	echo '<pre>';
        	print_r($this->getSthExecutePositional($entity));
        	echo '</pre>';
        	exit;
        	


			$sth->execute();
			// $this->tryExecute(__METHOD__, $sth, );
			if ($sth->rowCount()) {
				$lastInsertIds[] = intval($this->database->dbh->lastInsertId());
			}
        }

		// return
		$this->setLastInsertIds($lastInsertIds);
		return $this;
	}	
}
