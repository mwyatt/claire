<?php

namespace OriginalAppName\Site\Elttl\Helper;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Tennis
{


	/**
	 * @param  string $side
	 * @return string
	 */
	public static function getOtherSide($side = '')
	{
	    return $side == 'left' ? 'right' : 'left';
	}
}
