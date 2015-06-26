<?php

namespace OriginalAppName\Model\Database;

use OriginalAppName\Admin\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Version extends \OriginalAppName\Model
{	


	public $tableName = 'databaseVersion';

	
	public $fields = [
		'id',
		'name',
		'timePatched',
		'userId'
	];


	public $entity = '\\OriginalAppName\\Entity\\Database\\Version';


	/**
	 * apply a patch to the database
	 * might be better placed more globally?
	 * @param  string $query 
	 * @return object        
	 */
	public function applyPatch($query)
	{

		// query
		$sth = $this->database->dbh->prepare($query);

	    // execute
	    try {
		$sth->execute();
	    	
	    } catch (\Exception $e) {
	    	echo '<pre>';
	    	print_r($e);
	    	echo '</pre>';
	    	exit;
	    	
	    }

		// return
		return $this->setRowCount($sth->rowCount());
	}
}
