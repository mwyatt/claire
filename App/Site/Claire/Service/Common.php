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

		// main nav
		$json = new Json();
		$json->read('main-menu');

		// template
		return [
			'googleAnalyticsTrackingId' => '?',
			'mainMenu' => $json->getData(),
			'campaign' => new Analytics\Campaign
		];
	}
}
