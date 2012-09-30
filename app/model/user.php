<?php

/**
 * Manage User Data, Authentication
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends Model
{

	public $email;
	protected $password;
	

	public function __construct($DBH) {
		$this->DBH = $DBH;
	}
	
	
	public function setEmail($value) {
		$this->email = mysql_real_escape_string($value);
	}
	

	public function getEmail() {
		return ($this->email ? $this->email : false);
	}
	

	public function setPassword($value) {
		$this->password = hash('sha512', $value);
	}
	
	protected function getPassword() {
		return ($this->password ? $this->password : false);
	}
	
	/**
	  * Insert 1 Row into Database | Set Level
	  */
	public function insertMeta($user_id)
	{	
		$STH = $this->DBH->prepare("
			INSERT INTO user_meta
				(user_id, name, value)
			values
				('$user_id', :name, :value)
		");
		
		$STH->execute(
			array(
				':name' => 'first_name'
				, ':value' => 'Steve'
			)
		);
		$STH->execute(
			array(
				':name' => 'last_name'
				, ':value' => 'Smith'
			)
		);
	}
	
	
	/**
	 * Get all Users and pair with Meta Data
	 */
	public function getUser()
	{	
		$STH = $this->DBH->query("
			SELECT
				id
				, email
				, level
				, name
				, value
			FROM
				user
			LEFT JOIN
				user_meta
			ON
				user.id = user_meta.user_id
		");
		
		// Process Result Rows
		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->setRow($row['id'], 'email', $row['email']);
			$this->setRow($row['id'], 'level', $row['level']);
			$this->setRow($row['id'], $row['name'], $row['value']);
		
			/*$this->result[$row['id']]['email'] = $row['email'];
			$this->result[$row['id']]['level'] = $row['level'];
			$this->result[$row['id']][$row['name']] = $row['value'];	*/		
		}		
	}	

	
	/**
	  * Insert 1 Row into Database | Set Level
	  */
	public function insert($level = 1)
	{	
		$STH = $this->DBH->prepare("
			INSERT INTO user
				(email, password, level)
			values
				(:email, :password, '$level')
		");
		
		$STH->execute(
			array(
				':email' => $this->getEmail()
				, ':password' => $this->getPassword()
			)
		);
	}
	
	
	public function login()
	{	
		// Set Email & Password
		$this->setEmail($_POST['username']);
		$this->setPassword($_POST['password']);
		
		// Query
		$STH = $this->DBH->query("	
			SELECT
				id
				, email
				, level
				, name
				, value
			FROM
				user				
			LEFT JOIN
				user_meta
			ON
				user.id = user_meta.user_id		
			WHERE 
				email = '{$this->getEmail()}'
			AND
				password = '{$this->getPassword()}'					
		");
		
		// Process Result Rows
		while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {	
			$this->setRow($row['id'], 'email', $row['email']);
			$this->setRow($row['id'], 'level', $row['level']);
			$this->setRow($row['id'], $row['name'], $row['value']);
		}		
				
		$_SESSION['feedback'] = 'Incorrect Username and / or Password';
		
		return $this->getResult();
	}
	
	
	public function isLogged()
	{	
		if (array_key_exists('user', $_SESSION)) {
			return true;
		}
		return false;
	}
	
	
	public function logout()
	{	
		if (array_key_exists('user', $_SESSION)) {
			unset($_SESSION['user']);
		}
		return true;
	}
	
	
	public function setSession()
	{	
		$_SESSION['user']['id'] = $this->result['id'];
		$_SESSION['user']['email'] = $this->result['email'];
		$_SESSION['user']['date_registered'] = $this->result['date_registered'];
		$_SESSION['user']['level'] = $this->result['level'];
		return true;
	}
	
	public function get($key = 'username')
	{	
		return $_SESSION['user'][$key];
	}
	
	
	/*public function getUser()
	{	
		return ($_SESSION['user'] ? $_SESSION['user'] : false);
	}*/

	
}