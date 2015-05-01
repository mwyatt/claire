<?php

namespace OriginalAppName\Site\Claire\Controller;

use OriginalAppName\Entity;
use OriginalAppName\Response;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Service;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


	public function home() {
		$modelContent = new Model\Content;
		$modelContent->readLatest([
			'count' => 3,
			'type' => 'post'
		]);
		$this->view->setDataKey('contents', $modelContent->getData());
		return new Response($this->view->getTemplate('home'));
	}
}
