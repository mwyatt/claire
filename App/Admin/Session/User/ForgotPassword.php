<?php

namespace OriginalAppName\Admin\Session\User;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class ForgotPassword extends \OriginalAppName\Session\Expire
{


	protected $scope = 'OriginalAppName\Admin\Session\User\ForgotPassword';
	


	/**
	 * setup password reset interface
	 * expiry and randomised key to match
	 * email for getting user information in password reset
	 */
	public function setForgotPassword($key, $userId)
	{
		$this
			->set('userId', $userId)
			->set('expire', time() + ($this->getTime('hour') / 2 /* 30min */))
			->set('key', $key);
	}
}
