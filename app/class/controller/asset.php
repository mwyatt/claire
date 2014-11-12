<?php

namespace OriginalAppName\Controller;

use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Asset extends \OriginalAppName\Controller
{


	public function asset($request)
	{
		if (isset($request['path'])) {
			# code...
		}
		echo '<pre>';
		print_r($request);
		echo '</pre>';
		exit;
		
	}
}
