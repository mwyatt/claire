<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;

use OriginalAppName\Site\Elttl\Service\Tennis as ElttlServiceTennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Division extends \OriginalAppName\Entity
{


	private $name;


	private $yearId;


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
	 * @return int 
	 */
	public function getYearId() {
	    return $this->yearId;
	}
	
	
	/**
	 * @param int $yearId 
	 */
	public function setYearId($yearId) {
	    $this->yearId = $yearId;
	    return $this;
	}


	/**
	 * example.com/result/{year}/{division}/
	 * @return string url
	 */
	public function getUrl()
	{
		$generator = $this->getUrlGenerator();
		$serviceYear = new ElttlServiceTennis\Year();
		$yearSingle = $serviceYear->readId($this->getYearId());
		return $generator->generate(
			'result-year-division',
			[
				'year' => $yearSingle->getName(),
				'division' => \OriginalAppName\Helper::slugify($this->getName())
			],
			true
		);
	}
}
