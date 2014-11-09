<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

use OriginalAppName\Site\Elttl\Model\Tennis as ElttlModelTennis;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Year extends \OriginalAppName\Service
{


	public function readId($id)
	{
		$modelYear = new ElttlModelTennis\Year();
		$modelYear->readId([$id]);
		return current($modelYear->getData());
	}


	public function readName($name)
	{
		$modelYear = new ElttlModelTennis\Year();
		$modelYear->readId([$name], 'name');
		return current($modelYear->getData());
	}
}
