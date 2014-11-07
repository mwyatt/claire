<?php

namespace OriginalAppName;


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
}
