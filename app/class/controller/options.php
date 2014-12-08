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
class Options extends \OriginalAppName\Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->readOptions();
	}


	/**
	 * needs to be loaded for all controllers
	 * front, admin and ajax or any others
	 * @return null 
	 */
	public function readOptions()
	{
		$serviceOptions = new Service\Options();
		$this
			->view
			->setDataKey('option', $serviceOptions->read());
	}
}
