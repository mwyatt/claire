<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Response;
use OriginalAppName\Registry;
use OriginalAppName\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Division extends \OriginalAppName\Site\Elttl\Admin\Controller\Tennis\Crud
{


	public function update($id)
	{
		$registry = Registry::getInstance();
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entity = $this->model
			->readYearColumn(null, 'id', $id)
			->getDataFirst();

		// does not exist
		if (! $entity) {
			$this->redirect("admin/tennis/{$this->nameSingular}/all");
		}

		// consume post
		$entity->name = $_POST['entity']['name'];

		// save
		$this->model->updateYear(null, [$entity]);

		// feedback / route
		$sessionFeedback->setMessage(ucfirst($this->nameSingular) . " $id saved", 'positive');
		$this->redirect("admin/tennis/{$this->nameSingular}/single", ['id' => $entity->getId()]);
	}
}
