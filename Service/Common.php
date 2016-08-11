<?php

namespace OriginalAppName\Site\Claire\Service;

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
			'googleAnalyticsTrackingId' => 'UA-43311305-1',
			'socials' => [
				'twitter' => 'https://twitter.com/clmruth',
				'facebook' => 'https://www.facebook.com/clurrrpoof',
				'pinterest' => 'http://www.pinterest.com/clmruth26/',
				'google' => 'https://plus.google.com/100076113648548258052'
			],
			'menuPrimary' => $menu->getData(),
			'campaign' => new Analytics\Campaign
		];
	}
}
