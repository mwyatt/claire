<?php

/**
 * Database
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Database
{

	public $dbh;
	private $credentials = array(
		'host' => 'localhost',
		'port' => '80',
		'basename' => 'mvc_002',
		'username' => 'root',
		'password' => '',
	);
	
	
	public function __construct() {
		$this->connect();
	}
	
	
	public function connect() {
	
		try {
		
			// Set Data Source Name
			$dataSourceName = 'mysql:host='.$this->credentials['host']
				.';dbname='.$this->credentials['basename'];
			
			// Connect
			$this->dbh = new PDO(
				$dataSourceName,
				$this->credentials['username'],
				$this->credentials['password']
			);	
		
			// Set Error Mode
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch (PDOException $error) {

			echo '<h1>Unable to Connect to Database: '
				. $credentials['basename'] . '</h1>';
			exit;
			
		}	
	
	}
	
	public function getDbh() {
		return $this->dbh;
	}	
	
}
