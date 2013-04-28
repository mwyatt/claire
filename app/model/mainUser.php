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
	public function login($emailAddress, $password) {	
	
		$sth = $this->database->dbh->prepare("	
			select
				main_user.id
				, main_user.email
				, main_user.password
				, main_user.date_registered
				, main_user.level
				, main_user_meta.name as meta_name
				, main_user_meta.value as meta_value
			from main_user				
			left join main_user_meta on main_user.id = main_user_meta.user_id
			where email = :email
		");		
		
		$sth->execute(array(
			':email' => $emailAddress
		));

		if ($row = current($this->setMeta($sth->fetchAll(PDO::FETCH_ASSOC)))) {
			if (crypt($password, $row['password']) == $row['password']) {
				unset($row['password']);
				$session = new Session();
				$session->set('user', $row);
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * check the session variable for logged in user
	 */
	public function isLogged() {	
		$session = new Session();
		if ($session->get('user')) {
			return true;
		}
		return false;
	}
	
	
	public function logout() {	
		$session = new Session();
		$session->getUnset('user');
	}
	
	
	public function setSession() {	
		$session = new Session();
		$session->getUnset('user');
		$session->set('user', $this->getData());
	}
	
	public function get($one = null, $two = null, $three = null) {	
		$session = new Session();
		if ($one) {
			return $session->get('user', $one);
		}
		return $session->get('user');
	}
	


	public function checkPermission() {
		// $email = $this->get('email');
		// if ($email == 'martin.wyatt@gmail.com') {

		// }

		// if ($this->get('email') == 'martin.wyatt@gmail.com') {
		// 	$this->config->getObject('route')->home('admin/settings/');
		// }
		// if ($this->get('email') == 'Realbluesman@tiscali.co.uk') {
		// 	$this->config->getObject('route')->home('admin/league/fixture/fulfill/');
		// }
		// if ($this->get('email') == 'hepworth_neil@hotmail.com') {
		// 	$this->config->getObject('route')->home('admin/content/page/');
		// }
		// if ($this->get('email') == 'gsaggers6@aol.com') {
		// 	$this->config->getObject('route')->home('admin/league/player/');
		// }
		// if ($this->get('email') == 'henryrawcliffe@sky.com') {
		// 	$this->config->getObject('route')->home('admin/content/minutes/');
		// }


		// if ($this->config->getUrl(1)) {
		// 	# code...
		// }

		// if ($this->get('email') == 'martin.wyatt@gmail.com') {
		// 	$this->config->getObject('route')->home('admin/settings/');
		// }


		// if ($file = file_get_contents($path)) {

		// 	if ($position = strpos($file, '@access ')) {

		// 		$requiredLevel = substr($file, $position + 8, 2);
		// 		$requiredLevel = intval($requiredLevel);

		// 		$user = $this->get();
				
		// 		if ($user['level'] >= $requiredLevel)
		// 			return true;
		// 		else
		// 			return false;

		// 	} else {

		// 		return true;

		// 	}

		// }

	}


	public function permission() {
		if (array_key_exists('form_login', $_POST)) {
			if ($this->get('email') == 'martin.wyatt@gmail.com') {
				$this->config->getObject('route')->home('admin/settings/');
			}
			if ($this->get('email') == 'Realbluesman@tiscali.co.uk') {
				$this->config->getObject('route')->home('admin/league/fixture/fulfill/');
			}
			if ($this->get('email') == 'hepworth_neil@hotmail.com') {
				$this->config->getObject('route')->home('admin/content/press/');
			}
			if ($this->get('email') == 'gsaggers6@aol.com') {
				$this->config->getObject('route')->home('admin/league/player/');
			}
			if ($this->get('email') == 'henryrawcliffe@sky.com') {
				$this->config->getObject('route')->home('admin/content/minutes/');
			}
			$this->config->getObject('route')->home('admin/');
		}
		$feedback = 'Access denied. Please contact the administrator if you require access <a href="mailto:martin.wyatt@gmail.com">martin.wyatt@gmail.com</a>';
		if ($this->get('email') == 'Realbluesman@tiscali.co.uk') {
			if ($this->config->getUrl(1) != 'league') {
				$this->session->set('feedback', $feedback);
				$this->config->getObject('route')->home('admin/league/');
			}
		}
		if ($this->get('email') == 'hepworth_neil@hotmail.com') {
			if ($this->config->getUrl(2) != 'press') {
				$this->session->set('feedback', $feedback);
				$this->config->getObject('route')->home('admin/content/press/');
			}
		}
		if ($this->get('email') == 'gsaggers6@aol.com') {
			if ($this->config->getUrl(2) != 'player') {
				$this->session->set('feedback', $feedback);
				$this->config->getObject('route')->home('admin/league/player/');
			}
		}
		if ($this->get('email') == 'henryrawcliffe@sky.com') {
			if ($this->config->getUrl(2) != 'minutes') {
				$this->session->set('feedback', $feedback);
				$this->config->getObject('route')->home('admin/content/minutes/');
			}
		}
	}

	
}
