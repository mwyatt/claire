<?php

namespace OriginalAppName\Admin\Session;

use OriginalAppName\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Session\Expire
{


	protected $scope = 'OriginalAppName\Admin\Session\User';
	

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
			$sessionFeedback = new Session\Feedback;
			$sessionFeedback->set('You have been logged out due to inactivity');
			return;
		}

		// logged in
		return true;
	}
}
