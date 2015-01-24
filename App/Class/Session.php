<?php

namespace OriginalAppName;


/**
 * session object creates a layer between the $_SESSION variable to
 * help with management of it
 *
 * the session data is only modified when setting the data
 * when getting data simply use getData
 *
 * how to set the data once you have finished with the class? desctuct?
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Session extends \OriginalAppName\Cron
{


	protected $scope;


	/**
	 * extends the normal constructor to set the session data
	 */
	public function __construct($scope = '') {
		if ($scope) {
			$this->setScope($scope);
		}
		$this->initialiseData();
	}


	/**
	 * @return string 
	 */
	public function getScope() {
	    return $this->scope;
	}
	
	
	/**
	 * @param string $scope 
	 */
	public function setScope($scope) {
	    $this->scope = $scope;
	    return $this;
	}


	/**
	 * initialises the session data into the class data property
	 * adds a empty session key array
	 */
	public function initialiseData()
	{
		if (! array_key_exists($this->getScope(), $_SESSION)) {
			$_SESSION[$this->getScope()] = [];
		}
	}


	/**
	 * sets the session variable with information and updates
	 * the data packet
	 * @param string $key   
	 * @param any $value 
	 */
	public function setDataKey($key, $value)
	{
		$_SESSION[$this->getScope()][$key] = $value;
		return $this;
	}


	public function setData($value)
	{
		$_SESSION[$this->getScope()] = $value;
		return $this;
	}


	/**
	 * excends getdata from parent
	 * @param  string $key 
	 * @return any      
	 */
	public function getData()
	{	
		return $_SESSION[$this->getScope()];
	}	



	/**
	 * @return any 
	 */
	public function get($key) {
		if (isset($_SESSION[$this->getScope()][$key])) {
		    return $_SESSION[$this->getScope()][$key];
		}
	}
	
	
	/**
	 * set a key value pair
	 * @param string $key   
	 * @param any $value 
	 */
	public function set($key, $value) {
	    $_SESSION[$this->getScope()][$key] = $value;
	    return $this;
	}


	/**
	 * gets the value and unsets it
	 * @param  string $key 
	 * @return array      
	 */
	public function pull($key = '') {
		$data = null;
		if ($key) {
			if (array_key_exists($key, $_SESSION[$this->getScope()])) {
				$data = $_SESSION[$this->getScope()][$key];
				unset($_SESSION[$this->getScope()][$key]);
			}

		// no key return full package
		} else {
			$data = $_SESSION[$this->getScope()];
			$_SESSION[$this->getScope()] = null;
		}
		return $data;
	}


	/**
	 * just unsets the data
	 * could just pull to nothing?
	 * @param  boolean $key 
	 */
	public function delete() {
		unset($_SESSION[$this->getScope()]);
	}
}
