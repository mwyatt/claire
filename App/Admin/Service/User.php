<?php

namespace OriginalAppName\Admin\Service;

use OriginalAppName;
use OriginalAppName\Session;
use OriginalAppName\Model;
use OriginalAppName\Helper;


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
			return $sessionFeedback->setMessage('email address does not exist', 'negative');
		}
		$entityUser = current($modelUser->getData());

		// validate password
		if (! $entityUser->validatePassword($password)) {
			return $sessionFeedback->setMessage('password incorrect', 'negative');
		}

		// do the login
		$sessionUser->login($entityUser);
		$sessionFeedback->setMessage('welcome, ' . $entityUser->getNameFull());
	}


	/**
	 * check for valid email address
	 * reset the password
	 * set up session object
	 * create email and send
	 * @param  string $email 
	 * @return null        
	 */
	public function resetPassword($email)
	{
	
		// resource
		$sessionUser = new Session\Admin\User;
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;

		// find user by email
		$modelUser->readId([$email], 'email');
		if (! $modelUser->getData()) {
			return $sessionFeedback->setMessage('email address does not exist', 'negative');
		}
		$entityUser = current($modelUser->getData());

		// generate random key and setup session to expect it
		$sessionUser->setPasswordReset(Helper::getRandomString(20));

		// send email out
		$mail = new OriginalAppName\Mail;
		$mail->send([
			'subject' => 'Reset Password',
			'from' => ['admin@site.com' => 'Admin'],
			'to' => [$email],
			'template' => 'path/to/template'
		]);
		return $sessionFeedback->setMessage('an email has been sent to ' . $email, 'positive');
	}
}
