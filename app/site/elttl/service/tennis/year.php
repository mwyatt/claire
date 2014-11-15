<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

use OriginalAppName\Site\Elttl;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Year extends \OriginalAppName\Service
{


	public function readId($id)
	{
		$modelYear = new Elttl\Model\Tennis\Year();
		$modelYear->readId([$id]);
		return current($modelYear->getData());
	}


	public function readName($name)
	{
		$modelYear = new Elttl\Model\Tennis\Year();
		$modelYear->readId([$name], 'name');
		return current($modelYear->getData());
	}


	public function read()
	{
		$modelYear = new Elttl\Model\Tennis\Year();
		return $modelYear
			->read()
			->orderByProperty('name', 'desc')
			->getData();
	}
}
