<?php


/**
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Search extends Controller_Index
{


	public function run() {
		if (! array_key_exists('query', $_GET)) {
			$this->route('base');
		}
		$query = $_GET['query'];
		$query = htmlspecialchars($query);
		if (! $query) {
			$this->route('base');
		}
		$modelContent = new model_content($this);
		$modelContent->readSearch($query);
		$this->view
			->setDataKey('result_count', count($modelContent->getData()));

		// paginate and set slice of data
		$pagination = new pagination($this);
		$pagination->setTotalRows(count($modelContent->getData()));
		$pagination->initialise();
		$limit = $pagination->getLimit();
		$modelContent->setData(array_slice($modelContent->getData(), reset($limit), end($limit)));
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
		$this->view
			->setDataKey('query', $query)
			->setDataKey('contents', $modelContent)
			->setDataKey('pagination', $pagination)
			->setDataKey('pagination_summary', $pagination->getSummary())
			->getTemplate('search');
	}
}