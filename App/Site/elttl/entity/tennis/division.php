<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;

use OriginalAppName\Site\Elttl\Service\Tennis as ElttlServiceTennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Division extends \OriginalAppName\Site\Elttl\Entity\Tennis\Archive
{

	
	private $name;


	/**
	 * @return string 
	 */
	public function getName() {
	    return $this->name;
	}
	
	
	/**
	 * @param string $name 
	 */
	public function setName($name) {
	    $this->name = $name;
	    return $this;
	}


	/**
	 * example.com/result/{year}/{division}/
	 * @return string url
	 */
	public function getUrl($yearEntity)
	{
		$generator = $this->getUrlGenerator();
		return $generator->generate(
			'resultYearDivision',
			[
				'year' => $yearEntity->getName(),
				'division' => \OriginalAppName\Helper::slugify($this->getName())
			],
			true
		);
	}
}
