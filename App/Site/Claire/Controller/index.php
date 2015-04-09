<!-- mwyatt -->

<?php

namespace OriginalAppName\Site\Mwyatt\Controller;

use OriginalAppName\Response;
use OriginalAppName\Json;
use OriginalAppName\Google\Analytics\Campaign;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Service;



/**
 * Controller
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


	public function home() {
		$serviceContent = new Service\Content;
		$entitiesProject = $serviceContent->readType('project');
		shuffle($entitiesProject);

		// skills
		$json = new Json();
		$json->read('skills');
		$skills = $json->getData();

		// template
		$this
			->view
			->setDataKey('templateName', 'home')
			->setDataKey('skills', $skills)
			->setDataKey('projects', $entitiesProject);
		return new Response($this->view->getTemplate('home'));
	}


	public function search()
	{
		if (! isset($_REQUEST['query'])) {
			return new Response('', 404);
		}
	    return new Response('you are searching for: ' . $_REQUEST['query']);
	}
}


// claire

<?php


/**
 * Controller
 *
 * PHP version 5
 * 
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
		$this->view->setDataKey('mainMenu', $json->getData());
	}


	public function run()
	{
		if ($this->url->getPathPart(1)) {
			$this->redirect('base');
		}
		if (array_key_exists('query', $_GET)) {
			return $this->search();
		}
		return $this->home();
	}


	public function home() {

		// latest 3 posts
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
		$modelContent->bindUser();
		$this->view->setDataKey('contents', $modelContent->getData());
		$this->view->getTemplate('home');
	}
}
