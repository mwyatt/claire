<?php

namespace OriginalAppName\Admin\Controller\Ajax\Content;

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
class Meta extends \OriginalAppName\Admin\Controller\Ajax
{


	public function all()
	{

		// validate
		if (! isset($_GET['contentId'])) {
			throw new Exception;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;

		// action
		$modelContentMeta->readColumn('contentId', $_GET['contentId']);

		// output
		return new Response(json_encode($modelContentMeta->getData()));
	}


	public function create()
	{

		// validate
		if (! isset($_GET['contentId']) || ! isset($_GET['name']) || ! isset($_GET['value'])) {
			throw new Exception;
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
		return new Response(json_encode($modelContentMeta->getDataFirst()));
	}


	public function delete()
	{

		// validate
		if (! isset($_GET['id'])) {
			throw new Exception;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;
		$entitiesContentMeta = $modelContentMeta
			->readId([$_GET['id']])
			->getData();

		// action
		$modelContentMeta->delete($entitiesContentMeta);

		// output
		return new Response(json_encode($modelContentMeta->getRowCount()));
	}


	public function update()
	{
		
		// validate
		if (! isset($_REQUEST['id']) || ! isset($_REQUEST['contentId']) || ! isset($_REQUEST['name']) || ! isset($_REQUEST['value'])) {
			throw new Exception;
		}

		// resource
		$modelContentMeta = new Model\Content\Meta;
		$entityContentMeta = new Entity\Content\Meta;

		// action
		$entityContentMeta->consumeArray($_REQUEST);
		$modelContentMeta->update([$entityContentMeta]);

		// validate it happend
		if (! $modelContentMeta->getRowCount()) {
			throw new Exception;
		}

		// output
		$modelContentMeta->readId([$_REQUEST['id']]);
		return new Response(json_encode($modelContentMeta->getDataFirst()));
	}
}
