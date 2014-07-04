<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Database
{


	public $dbh;

	
	public $credentials;


	/**
	 * connects to the database
	 */
	public function __construct($credentials) {
		$this->setCredentials($credentials);
		$this->connect();
	}
	

	public function setCredentials($value)
	{
		$this->credentials = $value;
	}


	public function getCredentials() {
		return $this->credentials;
	}
	
	
	/**
	 * attempt connection to the database
	 * @return null 
	 */
	public function connect() {
		$credentials = $this->getCredentials();
		try {

			// set data source name
			$dataSourceName = 'mysql:host=' . $credentials->host
				 . ';dbname=' . $credentials->basename;
			
			// connect
			$this->dbh = new PDO(
				$dataSourceName,
				$credentials->username,
				$credentials->password
			);	
		
			// set error mode
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $error) {
			echo '<h1>Unable to Connect to Database</h1>';
			exit;
		}	
	}
}
