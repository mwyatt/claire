<?php

namespace OriginalAppName\Site\Elttl\Controller;

use Symfony\Component\HttpFoundation\Response;
use OriginalAppName\Json;
use OriginalAppName\Site\Elttl\Model\Tennis\Division;
use OriginalAppName\Google\Analytics\Campaign;
use OriginalAppName\Model;
use OriginalAppName\View;

/**
 * Controller
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller
{


	public function siteDefault()
	{

		// menu primary
		$json = new Json();
		$json->read('menu-primary');
		$menuPrimary = $json->getData();

		// menu Secondary
		$json = new Json();
		$json->read('menu-secondary');
		$menuSecondary = $json->getData();

		// menu Tertiary
		$json = new Json();
		$json->read('menu-tertiary');
		$menuTertiary = $json->getData();

		// divisions
		$modelTennisDivision = new Division();
		$modelTennisDivision->read();

		// template defaults
		return [
			'year' => 0,
			'divisions' => $modelTennisDivision->getData(),
			'menuPrimary' => $menuPrimary,
			'menuSecondary' => $menuSecondary,
			'campaign' => new Campaign(),
			'menuTertiary' => $menuTertiary
		];
	}


	public function home($request) {

		// ads
		$json = new Json();
		$json->read('ads');
		$ads = $json->getData();

		// 3 content
		$modelContent = new Model\Content();
		$modelContent
			->readType('press')
			->filterStatus('visible')
			->orderByProperty('timePublished', 'desc')
			->limitData([0, 3]);

		// cover
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
		$view = new View([
			'ads' => $ads,
			'covers' => $covers,
			'galleryPaths' => $files,
			'contents' => $modelContent->getData()
		]);
		return new Response($view->getTemplate('home'));
	}


	public function search()
	{
		if (! isset($_REQUEST['query'])) {
			throw new \Symfony\Component\Routing\Exception\ResourceNotFoundException();
		}
	    return new Response('you are searching for: ' . $_REQUEST['query']);
	}
}
