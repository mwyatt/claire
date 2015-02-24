<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\Model;
use OriginalAppName\Helper;
use OriginalAppName\Response;



/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller\Ajax
{


	public function forgotPassword()
	{

		// validation
		if (! isset($_REQUEST['email'])) {
			throw new Exception;
		}
		$email = $_REQUEST['email'];

		// resources
		$sessionFeedback = new Session\Feedback;
		$serviceUser = new Service\User;

		// resource
		$sessionForgotPassword = new AdminSession\User\ForgotPassword;
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;

		// find user by email
		$modelUser->readId([$email], 'email');
		if (! $modelUser->getData()) {
			$sessionFeedback->setMessage("no account with email address $email", 'negative');
			return new Response(json_encode($sessionFeedback->pull()));
		}
		$entityUser = current($modelUser->getData());

		// generate random key and setup session to expect it
		$key = Helper::getRandomString(20);
		$sessionForgotPassword->setForgotPassword($key, $entityUser->getId());

		// view for email
		$this
			->view
			->setDataKey('urlRecovery', $this->url->generate('admin/user/forgot-password/key', ['key' => $key]))
			->setDataKey('email', $email);
		$body = $this->view->getTemplate('admin/mail/user/forgot-password');

		// create email
		$mail = new OriginalAppName\Mail;
		$body = $mail->replaceTags($body);
		$mail->send([
			'subject' => 'Reset Password',
			'from' => ['admin@site.com' => 'Admin'],
			'to' => [$email],
			'body' => $body
		]);
		$sessionFeedback->setMessage('an email has been sent to ' . $email, 'positive');

		// feedback
		return new Response(json_encode($sessionFeedback->pull()));
	}
}
