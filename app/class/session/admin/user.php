<?php

namespace OriginalAppName\Session\Admin;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Session
{


	protected $scope = 'OriginalAppName\Session\Admin\User';
	

	/**
	 * stores user id
	 * @param  object $entity 
	 * @return null       
	 */
	public function login($entity = \OriginalAppName\Entity\User)
	{
		$this->set('id', $entity->getId());
		$this->setExpire();
	}


	/**
	 * checks to see if the session is set
	 * and refreshes the expiry
	 * @todo could make expire a built in session feature
	 * @return bool 
	 */
	public function isLogged()
	{

		// not logged in!
		if (! $this->get('id')) {
			return;
		}

		// provide feedback as to what has happened
		if (! $this->refreshExpire()) {
			$sessionFeedback = new OriginalAppName\Session\Admin\Feedback();
			$sessionFeedback->set('You have been logged out due to inactivity');
			return;
		}

		// logged in
		return true;
	}


	/**
	 * refreshes the expiry time
	 * @return bool 
	 */
	public function refreshExpire()
	{

		// set expire again if not expired
		if ($this->getData('expire') > time()) {
			return $this->setExpire();
		}

		// delete session it has expired!
		$this->delete();
	}


	/**
	 * sets the expire time, 1 hour after last check!
	 */
	public function setExpire()
	{
		return $this->set('expire', time() + $this->getTime('hour'));
	}
}
