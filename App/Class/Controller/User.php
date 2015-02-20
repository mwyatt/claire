<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Response;

use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Pagination;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller
{


	public function formAdminForgotPassword($request)
	{
			return new Response('', 404);


		// template
		$this
			->view
			->setDataKey('metaTitle', $entityContent->getTitle())
			->setDataKey('contents', $modelContent->getData());
		return new Response($this->view->getTemplate('content-single'));
		
	}
}
