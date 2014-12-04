<?php

namespace OriginalAppName\Site\Mwyatt\Controller;

use Symfony\Component\HttpFoundation\Response;
use OriginalAppName\Json;
use OriginalAppName\Google\Analytics\Campaign;
use OriginalAppName\Model;
use OriginalAppName\View;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


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


	public function home($request) {

		// all projects
		$modelProject = new Model\Project();
		$modelProject->read();

		// template
		$this->view->mergeData([
			'templateName' => 'home',
			'projects' => $modelProject->getData()
		]);
		return new Response($this->view->getTemplate('home'));
	}


	public function search()
	{
		if (! isset($_REQUEST['query'])) {
			throw new ResourceNotFoundException();
		}
	    return new Response('you are searching for: ' . $_REQUEST['query']);
	}
}
