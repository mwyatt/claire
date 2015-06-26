<?php

namespace OriginalAppName\Admin\Controller\System;

use OriginalAppName;
use OriginalAppName\Response;
use OriginalAppName\Entity;
use OriginalAppName\Model;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;


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
		if (!empty($_GET['update'])) {
			$this->update();
		}
		$serviceUpgrade = new Service\System\Upgrade;
		$serviceUpgrade->getVersionsPossible();
		$this->view->setDataKey('versionsPossible', $serviceUpgrade->getData());
		$serviceUpgrade->getVersionsUnpatched($serviceUpgrade->getData());
		$this->view->setDataKey('versionsUnpatched', $serviceUpgrade->getData());
		return new Response($this->view->getTemplate('admin/system/upgrade/all'));
	}


	public function update()
	{
		$feedback = new Session\Feedback;
		$user = new AdminSession\User;
		$serviceUpgrade = new Service\System\Upgrade;
		$serviceUpgrade->getVersionsPossible();
		$serviceUpgrade->getVersionsUnpatched($serviceUpgrade->getData());
		foreach ($serviceUpgrade->getData() as $patch) {
			$entity = new Entity\Database\Version;
			$model = new Model\Database\Version;
			$model->applyPatch(trim(file_get_contents($patch['path'])));

			// create entry
			$entity = new $model->entity;
			$entity->name = $patch['filename'];
			$entity->timePatched = time();
			$entity->userId = $user->get('id');
			$model->create([$entity]);
		}
		$feedback->setMessage('upgrade may have been ok' , 'positive');
		$this->redirect('admin/system/upgrade');
	}
}
