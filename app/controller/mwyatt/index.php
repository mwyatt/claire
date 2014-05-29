<?php

/**
 * Controller
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
 
class Controller_Index extends Controller
{


	public function initialise()
	{

		// main nav
		$json = new Json();
		$json->read('main-menu');
		$this->view->setObject('mainMenu', $json->getData());
	}


	public function run()
	{
		if ($this->url->getPathPart(1)) {
			$this->route('base');
		}
		if (array_key_exists('query', $_GET)) {
			return $this->search();
		}
		return $this->home();
	}


	public function home() {
		$cache = new cache($this);

		// latest 3 posts
		if ($cache->read('home-latest-posts')) {
			$this->view->setObject('contents', $cache->getData());
		} else {
			$modelContent = new model_content($this);
			$modelContent->read(array(
				'where' => array(
					'type' => 'post',
					'status' => 'visible'
				),
				'limit' => array(0, 6),
				'order_by' => 'time_published desc'
			));
			$modelContent->bindMeta('media');
			$modelContent->bindMeta('tag');
			$this->view->setObject('contents', $modelContent->getData());
			$cache->create($modelContent->getData());
		}
		$this->loadSkills();
		$this->view->getTemplate('home');
	}


	public function loadSkills()
	{
		$json = new Json($this);
		$json->read('skills');
		$this->view->setObject('skills', $json->getData());
	}
}
