<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Session;
use OriginalAppName\Admin;
use OriginalAppName\Model;
use OriginalAppName\Admin\Session as AdminSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * validation gateway for key codes
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class ForgotPassword extends \OriginalAppName\Admin\Controller\Feedback
{


	public function adminForgotPassword($request)
	{

		// resources
		$sessionForgotPassword = new AdminSession\User\ForgotPassword;
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;

		// handle submission
		if ($_POST) {

			// validation
			if (! isset($_POST['password']) || ! isset($_POST['password_confirm'])) {
				$sessionFeedback->setMessage('you need to define a new password and confirmation', 'negative');
				$this->route('adminForgotPassword', ['key' => $request['key']]);
			}

			// new passwords must be equal
			if ($_POST['password'] != $_POST['password_confirm']) {
				$sessionFeedback->setMessage('both password and confirm password must match', 'negative');
				$this->route('adminForgotPassword', ['key' => $request['key']]);
			}

			// save
			$modelUser->readId([$sessionForgotPassword->get('userId')]);
			$entityUser = $modelUser->getDataFirst();
			$entityUser->consumeArray($_REQUEST);
			$modelUser->update($entityUser, ['id' => $entityUser->getId()]);
			if ($modelUser->getRowCount()) {
				$sessionFeedback->setMessage('password saved', 'positive');
				$this->route('admin');
			}

			// failure
			$sessionFeedback->setMessage('unable to save password', 'negative');
			$this->route('adminForgotPassword', ['key' => $request['key']]);
		}

		// dependency
		if (! isset($request['key'])) {
			$sessionFeedback->setMessage('you need a key', 'negative');
			$this->route('admin');
		}

		// refresh expire
		if ($sessionForgotPassword->isExpire()) {
			$sessionForgotPassword->delete();
			$sessionFeedback->setMessage('your key has expired, please try again', 'negative');
			$this->route('admin');
		}

		// validation
		if (! $sessionForgotPassword->get('key')) {
			$sessionForgotPassword->delete();
			$sessionFeedback->setMessage('you need a key', 'negative');
			$this->route('admin');
		}

		// key must equal stored one
		if (! $request['key'] == $sessionForgotPassword->get('key')) {
			$sessionForgotPassword->delete();
			$sessionFeedback->setMessage('your key is incorrect', 'negative');
			$this->route('admin');
		}

		// find user by email
		$modelUser->readId([$sessionForgotPassword->get('userId')]);
		if (! $modelUser->getData()) {
			return $sessionFeedback->setMessage('no account with that email address', 'negative');
		}
		$entityUser = current($modelUser->getData());
		$this
			->view
			->setDataKey('userEmail', $entityUser->getEmail());
		return new Response($this->view->getTemplate('admin/forgot-password'));
	}
}
