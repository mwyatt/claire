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
class Session extends \OriginalAppName\Data
{


	protected $scope;


	/**
	 * extends the normal constructor to set the session data
	 */
	public function __construct($scope) {
		
		// $scope = 'OriginalAppName\Admin\User\'
		$this->setScope($scope)
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
		$this->setData($_SESSION[$this->getScope()]);
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
		return $this->setData($_SESSION[$this->getScope()]);
	}


	/**
	 * excends getdata from parent
	 * @param  string $key 
	 * @return any      
	 */
	public function getData($key = '')
	{	
		if (! $key) {
			return $this->data;
		}
		if (array_key_exists($key, parent::getData())) {
			return $this->data[$key];
		}
	}	


	/**
	 * sets all data assigned to session and the object
	 * @param int|bool|array $value 
	 */
	public function setData($value)
	{	
		$_SESSION[$this->getScope()] = $value;
		return parent::setData($value);
	}


	public function getDataKey($key)
	{
		if (array_key_exists($key, $_SESSION[$this->getScope()])) {
			$data = $_SESSION[$key];
			return $data;
		}
	}


	/**
	 * gets the array and unsets it
	 * @param  string $key 
	 * @return array      
	 */
	public function getUnset($key) {
		if (array_key_exists($key, $_SESSION[$this->getScope()])) {
			$data = $_SESSION[$key];
			unset($_SESSION[$key]);
			return $data;
		}
		return $data;
	}


	/**
	 * just unsets the data
	 * @param  boolean $key 
	 */
	public function delete($key = false) {
		if (! $key) {
			unset($_SESSION[$this->getScope()]);
		}
	}
}
