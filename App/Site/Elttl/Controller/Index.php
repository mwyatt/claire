<?php

namespace OriginalAppName\Site\Elttl\Controller;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


	public function home() {
echo '<pre>';
print_r('home');
echo '</pre>';
exit;

		// ads
		// replace with db version?
		$json = new Json();
		$json->read('ads');
		$ads = $json->getData();

		// 3 content
		$modelContent = new \OriginalAppName\Model\Content;
		$modelContent
			->readType('press')
			->filterStatus('visible')
			->orderByProperty('timePublished', 'desc')
			->limitData([0, 3]);

		// cover
		// replace with db version?
		$json = new Json();
		$json->read('home-cover');
		$covers = $json->getData();
		shuffle($covers);

		// gallery
		$folder = glob(SITE_PATH . 'asset' . DS . 'media' . DS . 'thumb' . DS . '*');
		$files = array();
		foreach ($folder as $filePath) {
			$filePath = str_replace(BASE_PATH, '', $filePath);
			$files[] = str_replace(DS, US, $filePath);
		}

		// template
		$this
			->view
			->setDataKey('ads', $ads)
			->setDataKey('covers', $covers)
			->setDataKey('galleryPaths', $files)
			->setDataKey('contents', $modelContent->getData());
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
