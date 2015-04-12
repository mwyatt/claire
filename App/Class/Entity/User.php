<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="user")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
	 * email address for the user, also used for logging in
     * @Column(type="string")
	 * @var string
	 */
	private $email;


	/**
	 * password for the user stored as sha5
     * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $password;


	/**
	 * first name
     * @Column(type="string")
	 * @var string
	 */
	private $nameFirst;


	/**
	 * last name
     * @Column(type="string")
	 * @var string
	 */
	private $nameLast;


	/**
	 * epoch time of registering
	 * @Column(type="integer")
	 * @var int
	 */
	private $timeRegistered;


	/**
	 * value for determining the permissions
	 * @Column(type="integer")
	 * @var int
	 */
	private $level;


	/**
	 * @return int 
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @return string 
	 */
	public function getEmail() {
	    return $this->email;
	}
	
	
	/**
	 * @param string $email 
	 */
	public function setEmail($email) {
	    $this->email = $email;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getPassword() {
	    return $this->password;
	}
	
	
	/**
	 * @todo always crypt? good idea?
	 * @param string $password 
	 */
	public function setPassword($password) {
	    $this->password = crypt($password);
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getNameFirst() {
	    return $this->nameFirst;
	}
	
	
	/**
	 * @param string $nameFirst 
	 */
	public function setNameFirst($nameFirst) {
	    $this->nameFirst = $nameFirst;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getNameLast() {
	    return $this->nameLast;
	}
	
	
	/**
	 * @param string $nameLast 
	 */
	public function setNameLast($nameLast) {
	    $this->nameLast = $nameLast;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getTimeRegistered() {
	    return $this->timeRegistered;
	}
	
	
	/**
	 * @param int $timeRegistered 
	 */
	public function setTimeRegistered($timeRegistered) {
	    $this->timeRegistered = $timeRegistered;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getLevel() {
	    return $this->level;
	}
	
	
	/**
	 * @param int $level 
	 */
	public function setLevel($level) {
	    $this->level = $level;
	    return $this;
	}


	/**
	 * check external password against entity value
	 * @param  string $password has been crypted
	 * @return bool
	 */
	public function validatePassword($password) {
		if (crypt($password, $this->getPassword()) == $this->getPassword()) {
			return true;
		}
	}


	/**
	 * Get either a Gravatar URL or complete image tag for a
	 * specified email address.
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source http://gravatar.com/site/implement/images/php/
	 */
	function getUrlGravatar($config) {
		
		// $user = new \OriginalAppName\Entity\User;
		// $user->setEmail('mike@gmail.com');
		// $url = $user->getUrlGravatar([
		// 	's' => 80,
		// 	'd' => 'mm',
		// 	'r' => 'g',
		// 	'img' => false
		// ]);
		
		// $email, $s = 80, $d = 'mm', $r = 'g', $img = false
		$query = [];
		$query = array_merge($query, $config);
	    $url = 'http://www.gravatar.com/avatar/';
	    $url .= md5(strtolower(trim($this->getEmail())));
	    $url .= '?' . http_build_query($query);
	    return $url;
	}


	public function getNameFull()
	{
		return implode(' ', [$this->getNameFirst(), $this->getNameLast()]);
	}
}
