<?php

namespace OriginalAppName\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as SymfonyResourceNotFound;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Pagination;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Controller
{


	/**
	 * all visible {type}
	 * @param  string $type e.g. post
	 * @return object       response
	 */
	public function contentAll($request) {
		$pagination = new Pagination();
		$modelContent = new Model\Content();
		$modelContent
			->readType($request['type'])
			->filterStatus('visible')
			->orderByProperty('timePublished', 'desc');
		if (! $modelContent->getData()) {
			throw new \Symfony\Component\Routing\Exception\ResourceNotFoundException();
		}
		$pagination->setTotalRows(count($modelContent->getData()));
		$pagination->initialise();
		$modelContent->limitData($pagination->getLimit());

		// single content
		$entityContent = current($modelContent->getData());

		// template
		$view = new View([
			'metaTitle' => 'All ' . $entityContent->getType(),
			'pagination' => $pagination,
			'contentSingle' => $entityContent,
			'contents' => $modelContent->getData()
		]);
		return new Response($view->getTemplate('content'));
	}


	/**
	 * a single {type} which has the {slug}
	 * @param  string $type content type
	 * @param  string $slug foo-bar
	 * @return object       response
	 */
	public function contentSingle($request)
	{
		$modelContent = new Model\Content();
		$modelContent->readSlug($request['slug']);
		if (! $modelContent->getData()) {
			throw new \Symfony\Component\Routing\Exception\ResourceNotFoundException();
		}
		$entityContent = current($modelContent->getData());
		if (! $entityContent->getType() == $request['type']) {
			throw new \Symfony\Component\Routing\Exception\ResourceNotFoundException();
		}
		if (! $entityContent->getStatus() == 'visible') {
			throw new \Symfony\Component\Routing\Exception\ResourceNotFoundException();
		}

		// template
		$view = new View([
			'metaTitle' => $entityContent->getTitle(),
			'contents' => $modelContent->getData()
		]);
		return new Response($view->getTemplate('content-single'));
	}
}
