<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Year extends \OriginalAppName\Entity\NameValue
{


	/**
	 * 2012-2013
	 * @return string 
	 */
	public function getNameFull()
	{
		$nameCurrent = $this->getName() + 0;
		return $nameCurrent . '-' . ($nameCurrent + 1);
	}


	/**
	 * example.com/result/{year}/
	 * @return string url
	 */
	public function getUrl()
	{
		$generator = $this->getUrlGenerator();
		return $generator->generate(
			'resultYear',
			[
				'year' => $this->getName()
			],
			true
		);
	}
}
