<?php

namespace OriginalAppName\Site\Mwyatt\Service;

use OriginalAppName\Google\Analytics;
use OriginalAppName\Json;
use OriginalAppName\Model;
use OriginalAppName\Menu;


/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Common extends \OriginalAppName\Service
{


	public function read()
	{

		// menu primary
		$modelMenu = new Model\Menu;
		$modelMenu->readColumn('keyGroup', 'primary');
		$menu = new Menu;
		$menu->buildTree($modelMenu->getData());

		// template
		return [
			'googleAnalyticsTrackingId' => 'UA-35261063-1',
			'menuPrimary' => $menu->getData(),
			'campaign' => new Analytics\Campaign
		];
	}
}
