<?php

namespace OriginalAppName\Controller;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * validation gateway for key codes
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Validate extends \OriginalAppName\Controller
{


	public function validateAdminForgotPassword($request)
	{

		// resources
		$sessionUser = new Session\Admin\User;

		// refresh expire
		$sessionUser->refreshExpire();

		// validation
		if (! isset($_REQUEST['key'])) {
			throw new ResourceNotFoundException();
		}

		// key must equal stored one
		if (! $_REQUEST['key'] == $sessionUser->get('key')) {
			throw new ResourceNotFoundException();
		}

		// valid, setup session
		$sessionUser->
		$this->route('')
		
	}
}
