<?php

namespace OriginalAppName\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller\Ajax
{


	public function ajaxAdminForgotPassword($request)
	{

		// validation
		if (! isset($_REQUEST['email'])) {
			throw new ResourceNotFoundException();
		}

		// resources
		$sessionFeedback = new Session\Feedback;
		$serviceUser = new Service\User;

		// reset the password
		$serviceUser->forgotPassword($this->view, $_REQUEST['email']);

		// feedback
		return new Response(json_encode($sessionFeedback->pull()), Response::HTTP_NOT_FOUND);
	}
}
