<?php

/**
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Content extends Controller_Index
{


	public function run()
	{
		if ($this->single()) {
			return;
		}
		if ($this->all()) {
			return;
		}
		$this->route('base');
	}


	public function single()
	{

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


	public function all() {

		// post/ only
		if ($this->url->getPathPart(1)) {
			$this->route('base');
		}

		// load
		$pagination = new pagination($this);
		$modelContent = new model_content($this);
		$cache = new cache($this);
		$modelContent->read();
		$pagination->setTotalRows(count($modelContent->getData()));
		$pagination->initialise();
		$modelContent->read(array(
			'where' => array(
				'type' => $this->url->getPathPart(0),
				'status' => 'visible'
			),
			'limit' => $pagination->getLimit(),
			'order_by' => 'time_published desc'
		));
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
		$firstContent = $modelContent->getData();
		$this->view
			->setMeta(array(		
				'title' => 'All posts'
			))
			->setObject('pageCurrent', $pagination->getCurrentPage())
			->setObject('pagination_summary', $pagination->getSummary())
			->setObject('first_content', current($firstContent))
			->setObject($pagination)
			->setObject('contents', $modelContent)
			->getTemplate('content');
		return true;
	}
}
