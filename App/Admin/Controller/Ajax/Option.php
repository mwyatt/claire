<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Entity;
use OriginalAppName\Session;
use OriginalAppName\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * untested
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Option extends \OriginalAppName\Admin\Controller\Ajax
{


	public function adminAjaxOptionAll($request)
	{

		// resource
		$modelOption = new Model\Option;

		// action
		$modelOption->read();

		// output
		return new Response(json_encode($modelOption->getData()));
	}


	public function adminAjaxOptionEdit($request)
	{

		// validate
		if (! isset($_REQUEST['name']) || ! isset($_REQUEST['value'])) {
			throw new ResourceNotFoundException;
		}

		// resource
		$modelOption = new Model\Option;
		$entityOption = new Entity\Option;

		// action
		$entityOption->consumeArray($_REQUEST);
		$modelOption
			->create([$entityOption])
			->readId($modelOption->getLastInsertIds());

		// output
		return new Response(json_encode($modelOption->getData()));
	}


	public function adminAjaxOptionDelete($request)
	{

		// validate
		if (! isset($_GET['id'])) {
			throw new ResourceNotFoundException;
		}

		// resource
		$modelOption = new Model\Option;

		// action
		$modelOption->delete(['id' => $_GET['id']]);

		// output
		return new Response(json_encode($modelOption->getRowCount()));
	}
}
