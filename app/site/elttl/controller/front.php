<?php

namespace OriginalAppName\Site\Elttl\Controller;

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


	public function defaultSite()
	{

		// menu primary
		$json = new Json();
		$json->read('menu-primary');
		$menuPrimary = $json->getData();

		// menu Secondary
		$json = new Json();
		$json->read('menu-secondary');
		$menuSecondary = $json->getData();

		// menu Tertiary
		$json = new Json();
		$json->read('menu-tertiary');
		$menuTertiary = $json->getData();

		// divisions
		$modelTennisDivision = new Division();
		$modelTennisDivision->read();

		// template
		$this->view->mergeData([
			'year' => 0,
			'divisions' => $modelTennisDivision->getData(),
			'menuPrimary' => $menuPrimary,
			'menuSecondary' => $menuSecondary,
			'campaign' => new Campaign(),
			'menuTertiary' => $menuTertiary
		]);
	}
}
