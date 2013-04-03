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
class Model_Mainuser extends Model
{

	public $email;
	protected $password;
		
	
	public function setEmail($value) {
		$this->email = $value;
		return $this;
	}
	

	public function getEmail() {
		return ($this->email ? $this->email : false);
	}
	

	public function setPassword($value) {
		$this->password = crypt($value);
		return $this;		
	}

	protected function getPassword() {
		return $this->password;
	}
	

	/**
	  * Insert 1 Row into Database | Set Level
	  */
	public function insertMeta($user_id) {	
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
	public function getUser() {	

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
	public function insert($level = 1) {	
		$sth = $this->database->dbh->prepare("
			INSERT INTO main_user
				(email, password, level)
			values
				(:email, :password, :level)
		");
		
		$sth->execute(
			array(
				':email' => $this->getEmail()
				, ':password' => $this->getPassword()
				, ':level' => $level
			)
		);
	}
	
	
	/**
	 * login user
	 * @return bool 
	 */
	public function login() {	
	
		$sth = $this->database->dbh->prepare("	

			select
				main_user.id
				, email
				, password
				, date_registered
				, level
				, meta.name as meta_name
				, meta.value as meta_value

			from
				main_user				

			left join
				main_user_meta as meta

			on
				main_user.id = meta.user_id		

			where 
				email = :email

		");		
		
		$sth->execute(array(
			':email' => $_POST['email_address']
		));

		if ($this->setDataStatement($sth)) {

			if (crypt($_POST['password'], parent::get('password')) == parent::get('password')) {

				$this->getObject('Session')->set('feedback', array('success', 'Successfully Logged in as ' . parent::get('first_name') . ' ' . parent::get('last_name')));

				return true;

			}

		}

		$this->getObject('Session')->set('feedback', array('error', 'Email Address or password incorrect'));

		return false;

	}
	
	
	/**
	 * check the session variable for logged in user
	 */
	public function isLogged() {	
		if (array_key_exists('user', $_SESSION)) {
			return true;
		}
	}
	
	
	public function logout() {	
	
		if (array_key_exists('user', $_SESSION))
			unset($_SESSION['user']);
			
	}
	
	
	public function setSession() {	
	
		unset($_SESSION['user']);
	
		foreach ($this->getData() as $key => $value) {
		
			$_SESSION['user'][$key] = $value;
		
		}
		
	}
	
	public function get($key = false) {

		if ($key) {

			return $_SESSION['user'][$key];

		} else {

			return $_SESSION['user'];

		}

	}
	
	public function setFeedback($string) {	
	
		$_SESSION['feedback'] = $string;
		
		return;

	}
	
	
	public function checkPermission($path) {

		if (! is_file($path))
			return false;

		if ($file = file_get_contents($path)) {

			if ($position = strpos($file, '@access ')) {

				$requiredLevel = substr($file, $position + 8, 2);
				$requiredLevel = intval($requiredLevel);

				$user = $this->get();
				
				if ($user['level'] >= $requiredLevel)
					return true;
				else
					return false;

			} else {

				return true;

			}

		}

	}
	
}
