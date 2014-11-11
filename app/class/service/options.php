<?php

namespace OriginalAppName\Service;

use OriginalAppName\Model;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Options extends \OriginalAppName\Service
{


	public function read()
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
