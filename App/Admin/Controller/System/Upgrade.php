<?php

namespace OriginalAppName\Admin\Controller\System;

use OriginalAppName;
use OriginalAppName\Response;
use OriginalAppName\Model;
use OriginalAppName\Admin\Service;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Upgrade extends \OriginalAppName\Controller\Admin
{


	/**
	 * @return object Response
	 */
	public function all() {

		// get possible versions
		$versionsPossible = [];
		$paths = glob(APP_PATH . 'sql' . DS . 'patch' . DS . '*.sql');
		foreach ($paths as $path) {
			$pathinfo = pathinfo($path);
			$pathinfo['path'] = $path;
			if (! empty($pathinfo['filename'])) {
				$versionsPossible[$pathinfo['filename']] = $pathinfo;
			}
		}

		// get patched versions
		$modelSystemVersion = new Model\System\Version;
		$modelSystemVersion->read();

		// subtract patched from possible to get unpatched
		$versionsUnpatched = $versionsPossible;
		foreach ($modelSystemVersion->getData() as $entitySystemVersion) {
			if (array_key_exists($entitySystemVersion->name, $versionsPossible)) {
				unset($versionsUnpatched[$entitySystemVersion->name]);
			}
		}
		$this
			->view
			->setDataKey('versionsUnpatched', $versionsUnpatched)
			->setDataKey('versionsPossible', $versionsPossible);
		return new Response($this->view->getTemplate('admin/system/upgrade/all'));
	}


	public function patch()
	{
		
	}
}
