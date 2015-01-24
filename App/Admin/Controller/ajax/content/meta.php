<?php

namespace OriginalAppName\Admin\Controller\Ajax\Content;

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
class Meta extends \OriginalAppName\Admin\Controller\Ajax
{


	public function adminAjaxContentMetaAll($request)
	{

		// validate
		if (! isset($_GET['contentId'])) {
			throw new ResourceNotFoundException;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;

		// action
		$modelContentMeta->readColumn('contentId', $_GET['contentId']);

		// output
		return new Response(json_encode($modelContentMeta->getData()));
	}


	public function adminAjaxContentMetaCreate($request)
	{

		// validate
		if (! isset($_GET['contentId']) || ! isset($_GET['name']) || ! isset($_GET['value'])) {
			throw new ResourceNotFoundException;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;
		$entityContentMeta = new Entity\Content\Meta;

		// action
		$entityContentMeta->consumeArray($_GET);
		$modelContentMeta
			->create([$entityContentMeta])
			->readId($modelContentMeta->getLastInsertIds());

		// output
		return new Response(json_encode($modelContentMeta->getData()));
	}


	public function adminAjaxContentMetaDelete($request)
	{

		// validate
		if (! isset($_GET['id'])) {
			throw new ResourceNotFoundException;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;

		// action
		$modelContentMeta->delete(['id' => $_GET['id']]);

		// output
		return new Response(json_encode($modelContentMeta->getRowCount()));
	}


	public function adminAjaxContentMetaUpdate($request)
	{
		
		// validate
		if (! isset($_REQUEST['contentId']) || ! isset($_REQUEST['name']) || ! isset($_REQUEST['value'])) {
			throw new ResourceNotFoundException;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;
		$entityContentMeta = new Entity\Content\Meta;

		// action
		$entityContentMeta->consumeArray($_REQUEST);
		$modelContentMeta->update($entityContentMeta, ['id' => $request['id']]);

		// validate it happend
		if (! $modelContentMeta->getRowCount()) {
			throw new ResourceNotFoundException;
		}

		// output
		$modelContentMeta->readId([$request['id']]);
		return new Response(json_encode($modelContentMeta->getDataFirst()));
	}
}
