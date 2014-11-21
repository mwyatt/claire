<?php

namespace OriginalAppName\Admin\Service;

use OriginalAppName\Session;
use OriginalAppName\Model;


class User extends \OriginalAppName\Service
{


	/**
	 * attempts a login of a user
	 * @param  string $email    
	 * @param  string $password 
	 * @return null           
	 */
	public function login($email, $password)
	{

		// resource
		$sessionUser = new Session\Admin\User;
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;

		// find user by email
		$modelUser->readId([$email], 'email');
		if (! $modelUser->getData()) {
			return $sessionFeedback->setMessage('email address does not exist');
		}
		$entityUser = current($modelUser->getData());

		// validate password
		if (! $entityUser->validatePassword($password)) {
			return $sessionFeedback->setMessage('password incorrect');
		}

		// do the login
		$sessionUser->login($entityUser);
		$sessionFeedback->setMessage('welcome, ' . $entityUser->getNameFull());
	}
}
