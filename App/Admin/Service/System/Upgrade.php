<?php

namespace OriginalAppName\Admin\Service\System;

use OriginalAppName;
use OriginalAppName\Model;


class Upgrade extends \OriginalAppName\Service
{


	public function getVersionsPossible()
	{
		$versionsPossible = [];
		$paths = glob(APP_PATH . 'sql' . DS . 'patch' . DS . '*.sql');
		foreach ($paths as $path) {
			$pathinfo = pathinfo($path);
			$pathinfo['path'] = $path;
			$pathinfo['modifiedTime'] = filemtime($path);
			if (! empty($pathinfo['filename'])) {
				$versionsPossible[$pathinfo['filename']] = $pathinfo;
			}
		}
		return $this->setData($versionsPossible);
	}


	public function getVersionsUnpatched($versionsPossible)
	{
		$modelDatabaseVersion = new Model\Database\Version;
		$modelDatabaseVersion->read();

		// subtract patched from possible to get unpatched
		$versionsUnpatched = $versionsPossible;
		foreach ($modelDatabaseVersion->getData() as $entityDatabaseVersion) {
			if (array_key_exists($entityDatabaseVersion->name, $versionsPossible)) {
				unset($versionsUnpatched[$entityDatabaseVersion->name]);
			}
		}
		return $this->setData($versionsUnpatched);
	}
}
