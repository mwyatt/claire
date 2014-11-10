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


	public function __construct($request)
	{
		if (method_exists($this, $request['_route'])) {
			return $this->$request['_route']($request);
		}
	    $this->notFound($request);
	}


	public function index()
	{
		$modelOptions = new Model\Options();
		$modelOptions
			->read()
			->keyDataByProperty('name');
		return [
			'option' => $modelOptions->getData()
		];
	}


	public function notFound($request)
	{
		// template
		$view = new View([
			'metaTitle' => 'Not found'
		]);
		return new Response($view->getTemplate('not-found'), Response::HTTP_NOT_FOUND);
	}
}
