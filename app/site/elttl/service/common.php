<?php

namespace OriginalAppName\Site\Elttl\Service;

use OriginalAppName\Site\Elttl\Model\Tennis;
use OriginalAppName\Json;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Common extends \OriginalAppName\Service
{


	public function read()
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
		$modelTennisDivision = new Model\Division();
		$modelTennisDivision->read();

		// template
		return [
			'googleAnalyticsTrackingId' => 'UA-35261063-1',
			'year' => 0,
			'divisions' => $modelTennisDivision->getData(),
			'menuPrimary' => $menuPrimary,
			'menuSecondary' => $menuSecondary,
			'campaign' => new Campaign(),
			'menuTertiary' => $menuTertiary
		];
	}
}
