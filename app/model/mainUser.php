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
class MainUser extends Model
{

	public $email;
	protected $password;
		
	
	public function setEmail($value) {
		$this->email = mysql_real_escape_string($value);
		return $this;
	}
	

	public function getEmail() {
		return ($this->email ? $this->email : false);
	}
	

	public function setPassword($value) {
		$this->password = hash('sha512', $value);
		return $this;		
	}
	
	protected function getPassword() {
		return ($this->password ? $this->password : false);
	}
	
	/**
	  * Insert 1 Row into Database | Set Level
	  */
	public function insertMeta($user_id)
	{	
		$sth = $this->database->dbh->prepare("
			INSERT INTO main_user_meta
				(user_id, name, value)
			values
				('$user_id', :name, :value)
		");
		
		$sth->execute(
			array(
				':name' => 'first_name'
				, ':value' => 'Steve'
			)
		);
		$sth->execute(
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

		$sth = $this->database->dbh->query("
			SELECT
				id
				, email
				, level
				, name
				, value
			FROM
				main_user
			LEFT JOIN
				main_user_meta
			ON
				user.id = main_user_meta.user_id
		");
		
		// Process Result Rows
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$this->setRow($row['id'], 'email', $row['email']);
			$this->setRow($row['id'], 'level', $row['level']);
			$this->setRow($row['id'], $row['name'], $row['value']);
		}		
	}	

	
	/**
	  * Insert 1 Row into Database | Set Level
	  */
	public function insert($level = 1)
	{	
		$sth = $this->database->dbh->prepare("
			INSERT INTO main_user
				(email, password, level)
			values
				(:email, :password, '$level')
		");
		
		$sth->execute(
			array(
				':email' => $this->getEmail()
				, ':password' => $this->getPassword()
			)
		);
	}
	
	
	/**
	 * login user based on post data
	 */
	public function login()
	{	
	
		$this->setEmail($_POST['username']);
		$this->setPassword($_POST['password']);
		
		$sth = $this->database->dbh->query("	
			SELECT
				main_user.id
				, email
				, date_registered
				, level
				, meta.name as meta_name
				, meta.value as meta_value
			FROM
				main_user				
			LEFT JOIN
				main_user_meta as meta
			ON
				main_user.id = meta.user_id		
			WHERE 
				email = '{$this->getEmail()}'
			AND
				password = '{$this->getPassword()}'					
		");
		
		$this->parseRows($sth);
		
		if ($this->getData()) {
			
			$this->setSession();
			return true;
			
		} else {
		
			$_SESSION['feedback'] = 'Incorrect Username or Password, or both!';
			return false;
		
		}
		
	}
	
	
	/**
	 * check the session variable for logged in user
	 */
	public function isLogged()
	{	
	
		if (array_key_exists('user', $_SESSION))
			return true;
		/*else
			return false;*/
			
	}
	
	
	public function logout()
	{	
	
		if (array_key_exists('user', $_SESSION))
			unset($_SESSION['user']);
			
	}
	
	
	public function setSession()
	{	
	
		unset($_SESSION['user']);
	
		foreach ($this->getData() as $key => $value) {
		
			$_SESSION['user'][$key] = $value;
		
		}
		
	}
	
	public function get($key)
	{	
		return $_SESSION['user'][$key];
	}
	
	public function setFeedback($string)
	{	
	
		$_SESSION['feedback'] = $string;
		
		return;

	}
	
	
	
}