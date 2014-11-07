<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Pagination;
use OriginalAppName\Model;


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
	public static function all($type) {
		$pagination = new Pagination();
		$modelContent = new Model\Content();
		$modelContent
			->readType($type)
			->filterStatus('visible')
			->orderByProperty('timePublished', 'desc');
		if (! $modelContent->getData()) {
			// 404
		}
		$pagination->setTotalRows(count($modelContent->getData()));
		$pagination->initialise();



// get media and tag meta info using ids
// get all meta for each content
// group by [name] key then refer when looping
// 


		// $modelContent->bindMeta('media');
		// $modelContent->bindMeta('tag');
		$contentSingle = $modelContent->getData();
		$view = new \OriginalAppName\View([
			'metaTitle' => 'All ' . $contentSingle->getStatus(),
			'metaDescription' => '',
			'pagination' => $pagination,
			'contentSingle' => current($contentSingle),
			'contents' => $modelContent
		]);

		// a return value from a service?
		$view->append(['key' => 'value'])
		return $view->getTemplate('content');
	}


	public static function single($type, $slug)
	{

		echo '<pre>';
		print_r($type);
		echo '<pre>';
		print_r($name);
		exit;
		

		// foo-bar
		if (! isset($args['title'])) {
			return;
		}

		// type/slug/
		if (! $this->url->getPathPart(1)) {
			return;
		}

		// read by slug and type
		$modelContent = new model_content($this);
		$modelContent->read(array(
			'where' => array(
				'slug' => $this->url->getPathPart(1),
				'status' => 'visible',
				'type' => $this->url->getPathPart(0)
			)
		));
		
		if (! $modelContent->getData()) {
			$this->route('base');
		}
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');

		// set view
		$this->view
			->setMeta(array(		
				'title' => $modelContent->getData('title')
			))
			->setObject('contents', $modelContent)
			->getTemplate('content-single');
		return true;
	}
}
