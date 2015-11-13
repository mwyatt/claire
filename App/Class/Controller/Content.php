<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Response;
use \Exception;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Pagination;
use OriginalAppName\Entity;
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
	public function all($type)
	{
		$pagination = new Pagination();
		$modelContent = new Model\Content();
		$modelContent
			->readType($type)
			->filterStatus(Entity\Content::STATUS_PUBLISHED)
			->orderByProperty('timePublished', 'desc');
		if (! $modelContent->getData()) {
			return new Response('', 404);
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
	public function single($type, $slug)
	{
		$serviceContent = new Service\Content();
		$serviceContent->readSlug($slug);
		if (! $serviceContent->getData()) {
			return new Response('', 404);
		}

		// validate
		$entities = [];
		foreach ($serviceContent->getData() as $entityContent) {
			if ($entityContent->getType() == $type && $entityContent->getStatus() == \OriginalAppName\Entity\Content::STATUS_PUBLISHED) {
				$entities[] = $entityContent;
			}
		}

		// any?
		if (!$entities) {
			return new Response('', 404);
		}

		// template
		$this
			->view
			->setDataKey('metaTitle', $entityContent->getTitle())
			->setDataKey('contents', $entities);
		return new Response($this->view->getTemplate('content-single'));
	}
}
