<?php

namespace OriginalAppName\Admin\Service;

use OriginalAppName;
use OriginalAppName\View;
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
			return $sessionFeedback->setMessage('email address \'' . $email . '\' does not exist', 'negative');
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
	public function forgotPassword($view, $email)
	{
	
		// resource
		$sessionUser = new Session\Admin\User;
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;

		// find user by email
		$modelUser->readId([$email], 'email');
		if (! $modelUser->getData()) {
			return $sessionFeedback->setMessage('no account with that email address', 'negative');
		}
		$entityUser = current($modelUser->getData());

		// generate random key and setup session to expect it
		$key = Helper::getRandomString(20);
		$sessionUser->setPasswordReset($key);

		// view for email
		$view
			->setDataKey('urlRecovery', $view->getUrl('adminUserForgotPassword') . '?key=' . $key)
			->setDataKey('key', $key)
			->setDataKey('email', $email);
		$body = $view->getTemplate('admin/mail/user/forgot-password');

		// create email
		$mail = new OriginalAppName\Mail;
		$body = $mail->replaceTags($body);
		$mail->send([
			'subject' => 'Reset Password',
			'from' => ['admin@site.com' => 'Admin'],
			'to' => [$email],
			'body' => $body
		]);
		return $sessionFeedback->setMessage('an email has been sent to ' . $email, 'positive');
	}
}
