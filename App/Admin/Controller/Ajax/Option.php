<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Entity;
use OriginalAppName\Session;
use OriginalAppName\Model;
use OriginalAppName\Response;



/**
 * untested
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Option extends \OriginalAppName\Admin\Controller\Ajax
{


	public function adminAjaxOptionRead($request)
	{

		// resource
		$modelOption = new Model\Option;

		// action
		$modelOption->read();

		// output
		return new Response(json_encode($modelOption->getData()));
	}


	public function adminAjaxOptionCreate($request)
	{

		// validate
		if (! isset($_REQUEST['name']) || ! isset($_REQUEST['value'])) {
			throw new ResourceNotFoundException;
		} elseif (! $_REQUEST['name'] || ! $_REQUEST['value']) {
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
		return new Response(json_encode($modelOption->getDataFirst()));
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


	public function adminAjaxOptionUpdate($request)
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
		$modelOption->update($entityOption, ['id' => $request['id']]);
			;

		// validate it happend
		if (! $modelOption->getRowCount()) {
			throw new ResourceNotFoundException;
		}

		// output
		$modelOption->readId([$request['id']]);
		return new Response(json_encode($modelOption->getDataFirst()));
	}
}
