<?php

namespace OriginalAppName\Admin\Service\User;

use OriginalAppName;
use OriginalAppName\Registry;


class Permission extends \OriginalAppName\Service
{


	public function getAdminRoutes()
	{
		$registry = Registry::getInstance();
		$registryUrl = $registry->get('url');
		$routes = [];
		foreach ($registryUrl->routes as $route => $body) {
			if (strpos($route, 'admin') !== false) {
				$routes[] = $route;
			}
		}
		return $routes;
	}
}
