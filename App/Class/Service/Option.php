<?php

namespace OriginalAppName\Service;

use OriginalAppName\Model;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Option extends \OriginalAppName\Service
{


	public function read()
	{
		$modelOption = new Model\Option();
		$modelOption
			->read()
			->keyDataByProperty('name');
		return $modelOption->getData();
	}
}
