<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Session;
use OriginalAppName\Admin;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * validation gateway for key codes
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller
{


	public function adminUserForgotPassword($request)
	{

		// resources
		$sessionUser = new Admin\Session\User;
		$sessionFeedback = new Session\Feedback;

		// refresh expire
		if ($sessionUser->isExpire()) {
			$sessionUser->delete();
			$sessionFeedback->setMessage('your key has expired, please try again', 'negative');
			$this->route('admin');
		}

		// validation
		if (! isset($_REQUEST['key'])) {
			$sessionUser->delete();
			$sessionFeedback->setMessage('you need a key first', 'negative');
			$this->route('admin');
		}

		// key must equal stored one
		if (! $_REQUEST['key'] == $sessionUser->get('key')) {
			$sessionUser->delete();
			$sessionFeedback->setMessage('your key is incorrect, please try again', 'negative');
			$this->route('admin');
		}

		// valid, show form
		// $this->route('')
		exit('form');
	}
}

