<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Model;
use OriginalAppName\Session;
use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ajax extends \OriginalAppName\Controller\Admin
{


	public function adminAjaxContentSingle($request)
	{

		// must be looking specifically for an id
		if (! isset($request['id'])) {
			throw new ResourceNotFoundException();
		}

		// read the 
		$modelContent = new Model\Content();
		$modelContent->readId([$request['id']]);

echo '<pre>';
print_r($modelContent->getData());
echo '</pre>';
exit;


		if (! $modelContent->getData()) {
			throw new ResourceNotFoundException();
		}
		$entityContent = current($modelContent->getData());
		if (! $entityContent->getType() == $request['type']) {
			throw new ResourceNotFoundException();
		}
		if (! $entityContent->getStatus() == 'visible') {
			throw new ResourceNotFoundException();
		}

		// template
		$this
			->view
			->setDataKey('metaTitle', $entityContent->getTitle())
			->setDataKey('contents', $modelContent->getData());
		return new Response($this->view->getTemplate('content-single'));
	}
}
