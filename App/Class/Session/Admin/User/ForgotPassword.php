<?php

namespace OriginalAppName\Session\Admin\User;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class ForgotPassword extends \OriginalAppName\Session\Expire
{


	protected $scope = 'OriginalAppName\Session\Admin\User\ForgotPassword';
	


	/**
	 * setup password reset interface
	 * expiry and randomised key to match
	 * 30 min expire time
	 */
	public function setForgotPassword($key)
	{
		$this
			->set('expire', time() + ($this->getTime('hour') / 2 /* 30min */))
			->set('key', $key);
	}


	public function setFormForgotPassword($email)
	{
		
	}
}
