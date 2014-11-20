<?php

namespace OriginalAppName\Controller;

use Symfony\Component\HttpFoundation\Response;
use OriginalAppName\Json;
use OriginalAppName\Site\Elttl\Model\Tennis\Division;
use OriginalAppName\Google\Analytics\Campaign;
use OriginalAppName\Model;
use OriginalAppName\View;


/**
 * Controller
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Front extends \OriginalAppName\Controller
{


	public function __construct()
	{
		Parent::__construct();
		$this->defaultGlobalSite();
	}


	/**
	 * store default data in view
	 * store default site date in view
	 * @return null 
	 */
	public function defaultGlobalSite()
	{
		$className = '\\OriginalAppName\\Site\\' . ucfirst(SITE) . '\\Service\\Common';
		$serviceCommon = new $className;
		$this
			->view
			->mergeData($serviceCommon->read());
	}
}