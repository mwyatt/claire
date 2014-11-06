<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Database
{


	/**
	 * PDO object once connected
	 * @var object
	 */
	public $dbh;

	
	/**
	 * connection credentials
	 * @var array
	 */
	public $credentials;


	/**
	 * connects to the database
	 */
	public function __construct($credentials) {
		$this->setCredentials($credentials);
		$this->validateCredentials();
		$this->connect();
	}
	

	public function validateCredentials()
	{
		$expected = array(
			'host',
			'port',
			'basename',
			'username',
			'password'
		);
		if (! Helper::arrayKeyExists($expected, $this->getCredentials())) {
			exit('database validateCredentials failed');
		}
	}


	/**
	 * @return array 
	 */
	public function getCredentials() {
	    return $this->credentials;
	}
	
	
	/**
	 * @param array $credentials 
	 */
	public function setCredentials($credentials) {
	    $this->credentials = $credentials;
	    return $this;
	}
	
	
	/**
	 * attempt connection to the database
	 * @return null 
	 */
	public function connect() {
		$credentials = $this->getCredentials();
		try {

			// set data source name
			$dataSourceName = 'mysql:host=' . $credentials['host']
				 . ';dbname=' . $credentials['basename'];
			
			// connect
			$this->dbh = new \PDO(
				$dataSourceName,
				$credentials['username'],
				$credentials['password']
			);	
		
			// set error mode
			$this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $error) {
			exit('unable to connect to database');
		}	
	}


	/**
	 * returns the latest insert id from the database
	 * @return int|bool 
	 */
	public function getLastInsertId()
	{
		return $this->dbh->lastInsertId();
	}
}
