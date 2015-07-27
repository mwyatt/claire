<?php

namespace OriginalAppName\Admin\Controller\System;

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
		$serviceUpgrade = new \OriginalAppName\Service\System\Upgrade;
		$serviceUpgrade->getVersionsPossible();
		$this->view->setDataKey('versionsPossible', $serviceUpgrade->getData());
		$serviceUpgrade->getVersionsUnpatched($serviceUpgrade->getData());
		$this->view->setDataKey('versionsUnpatched', $serviceUpgrade->getData());
		return new \OriginalAppName\Response($this->view->getTemplate('admin/system/upgrade/all'));
	}


	public function update()
	{
		$feedback = new \OriginalAppName\Session\Feedback;
		$user = new \OriginalAppName\Admin\Session\User;
		$serviceUpgrade = new \OriginalAppName\Service\System\Upgrade;
		$serviceUpgrade->getVersionsPossible();
		$serviceUpgrade->getVersionsUnpatched($serviceUpgrade->getData());
		foreach ($serviceUpgrade->getData() as $patch) {
			$entity = new \OriginalAppName\Entity\Database\Version;
			$model = new \OriginalAppName\Model\Database\Version;
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
