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





		
		$modelContentMeta = new model_content_meta($this);
		if (! $modelContentMeta->delete(
			$_GET['content_id']
			, $_GET['name']
			, $_GET['values']
		)) {
			exit (json_encode(false));
		}
		exit (json_encode(true));
	}
}
