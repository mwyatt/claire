<?php


/**
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Month extends Controller_Index
{


	public function index() {
		$content = new model_content($this);
		
		// is the date acceptable
		if (! $content->readByMonth(array($this->url->getPathPart(1)))) {
			$this->redirect('404');
		}
		
		// make month pretty
		$monthYear = explode('-', $this->url->getPathPart(1));
		$monthYear = ucfirst(current($monthYear)) . ' ' . next($monthYear);

		// view
		$this->view
			->setMeta(array(		
				'title' => 'All posts from ' . $monthYear
			))
			->setDataKey('month_year', $monthYear)
			->setDataKey($content)
			->getTemplate('content-month');
	}
}