<?php

namespace OriginalAppName\Controller;

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
	 * all visible {type}
	 * @param  string $type e.g. post
	 * @return object       response
	 */
	public function contentAll($request)
	{
		$pagination = new Pagination();
		$modelContent = new Model\Content();
		$modelContent
			->readType($request['type'])
			->filterStatus('visible')
			->orderByProperty('timePublished', 'desc');
		if (! $modelContent->getData()) {
			throw new ResourceNotFoundException();
		}
		$pagination->setTotalRows(count($modelContent->getData()));
		$pagination->initialise();
		$modelContent->limitData($pagination->getLimit());

		// single content
		$entityContent = current($modelContent->getData());

		// template
		$this
			->view
			->setDataKey('metaTitle', 'All ' . $entityContent->getType())
			->setDataKey('pagination', $pagination)
			->setDataKey('contentSingle', $entityContent)
			->setDataKey('contents', $modelContent->getData());
		return new Response($this->view->getTemplate('content'));
	}


	/**
	 * a single {type} which has the {slug}
	 * @param  string $type content type
	 * @param  string $slug foo-bar
	 * @return object       response
	 */
	public function contentSingle($request)
	{
		$serviceContent = new Service\Content();
		$serviceContent->readSlug($request['slug']);
		if (! $serviceContent->getData()) {
			throw new ResourceNotFoundException();
		}
		$entityContent = current($serviceContent->getData());
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
			->setDataKey('contents', $serviceContent->getData());
		return new Response($this->view->getTemplate('content-single'));
	}
}
