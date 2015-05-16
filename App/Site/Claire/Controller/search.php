<?php

namespace OriginalAppName\Site\Claire\Controller;

use OriginalAppName;
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
class Search extends \OriginalAppName\Controller\Front
{


	public function primary() {
		if (empty($_GET['query'])) {
			$this->redirect('home');
		}
		$query = $_GET['query'];
		$modelContent = new Model\Content;
		$modelContent->readSearch($query);
		$this->view
			->setDataKey('resultCount', count($modelContent->getData()));

		// paginate and set slice of data
		$pagination = new OriginalAppName\Pagination;
		$pagination->setTotalRows(count($modelContent->getData()));
		$pagination->initialise();
		$limit = $pagination->getLimit();
		$modelContent->setData(array_slice($modelContent->getData(), reset($limit), end($limit)));
		$this->view
			->setDataKey('query', $query)
			->setDataKey('contents', $modelContent->getData())
			->setDataKey('pagination', $pagination)
			->setDataKey('paginationSummary', $pagination->getSummary());
		return new Response($this->view->getTemplate('search'));
	}
}
