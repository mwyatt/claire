<?php

namespace OriginalAppName;

use OriginalAppName\View;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller extends \OriginalAppName\Route
{


	public static function index()
	{
		$modelOptions = new Model\Options();
		$modelOptions
			->read()
			->keyDataByProperty('name');
		return [
			'option' => $modelOptions->getData()
		];
	}


	public static function home() {
		$modelContent = new Model\Content();
		$modelContent
			->readType('post')
			->filterStatus('visible')
			->orderByProperty('timePublished', 'desc')
			->limitData([0, 3]);

		// gallery
		$folder = glob(BASE_PATH . 'media' . DS . SITE . DS . 'thumb' . DS . '*');
		$files = array();
		foreach ($folder as $filePath) {
			$filePath = str_replace(BASE_PATH, '', $filePath);
			$files[] = str_replace(DS, US, $filePath);
		}

		// template
		$view = new View([
			'galleryPaths' => $files,
			'contents' => $modelContent->getData()
		]);
		return new Response($view->getTemplate('home'));
	}


	public static function notFound()
	{
		// template
		$view = new View([
			'metaTitle' => 'Not found'
		]);
		return new Response($view->getTemplate('not-found'), Response::HTTP_NOT_FOUND);
	}
}
