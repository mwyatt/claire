<?php

namespace OriginalAppName\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
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
			throw new ResourceNotFoundException();


		// template
		$this->view->mergeData([
			'metaTitle' => $entityContent->getTitle(),
			'contents' => $modelContent->getData()
		]);
		return new Response($this->view->getTemplate('content-single'));
		
	}
}
