<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

use OriginalAppName\Site\Elttl;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Division extends \OriginalAppName\Service
{


	public function readYearIdName($yearId, $name)
	{
		$modelDivision = new Elttl\Model\Tennis\Division();
		$modelDivision
			->readId([$yearId], 'yearId')
			->filterData('name', ucfirst($name));
		return current($modelDivision->getData());
	}
}
