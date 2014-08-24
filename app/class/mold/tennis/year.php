<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mold_Tennis_Year extends Mold_Meta
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
}
