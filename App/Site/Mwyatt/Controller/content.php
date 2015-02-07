<?php

namespace OriginalAppName\Site\Mwyatt\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Pagination;
use OriginalAppName\Service;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Controller\Front
{


	/**
	 * a single {type} which has the {slug}
	 * @param  string $type content type
	 * @param  string $slug foo-bar
	 * @return object       response
	 */
	public function projectSingle($request)
	{
		$serviceContent = new Service\Content();
		$serviceContent->readSlug($request['slug']);
		if (! $serviceContent->getData()) {
			throw new ResourceNotFoundException();
		}
		$entityContent = current($serviceContent->getData());
		if (! $entityContent->getStatus() == 'visible') {
			throw new ResourceNotFoundException();
		}

		// template
		$this
			->view
			->setDataKey('metaTitle', $entityContent->getTitle())
			->setDataKey('contents', $serviceContent->getData());
		return new Response($this->view->getTemplate('project-single'));
	}
}
