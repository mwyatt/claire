<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Response;
use OriginalAppName\Session;
use OriginalAppName\Site\Elttl\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Site\Elttl\Admin\Controller\Tennis\Crud
{


	public function create()
	{
		$entity = new $this->nsEntity;
		$entity->yearId = $this->yearId;
		$this->model->create([$entity]);
		$this->update(current($this->model->getLastInsertIds()));
	}


	public function all() {
		$division = new Model\Tennis\Division;
		$division
			->readColumn('yearId', $this->yearId)
			->keyDataByProperty('id');
		$this
			->model
			->readColumn('yearId', $this->yearId)
			->orderByProperty('name')
			->orderByProperty('divisionId');
		$this
			->view
			->setDataKey('divisions', $division->getData())
			->setDataKey($this->namePlural, $this->model->getData());
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/all"));
	}


	public function single($id = 0)
	{
		$entity = $this->model
			->readId([$id])
			->getDataFirst();
		$division = new Model\Tennis\Division;
		$division->readColumn('yearId', $this->yearId);
		$this
			->view
			->setDataKey('division', $entity ? $entity : new $this->nsEntity);
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/single"));
	}


	public function update($id)
	{
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entity = $this->model
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entity) {
			$this->redirect("admin/tennis/{$this->nameSingular}/all");
		}

		// consume post
		$entity->name = $_POST['entity']['name'];

		// save
		$this->model->update($entity, ['id' => $entity->getId()]);

		// feedback / route
		$sessionFeedback->setMessage("Division $id saved", 'positive');
		$this->redirect("admin/tennis/{$this->nameSingular}/single", ['id' => $entity->getId()]);
	}


	/**
	 * ajax because it is the only way i can do a delete request?
	 * @param  int $id 
	 * @return object     response
	 */
	public function delete($id)
	{
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entityDivision = $this->model
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityDivision) {
			return new Response('', 404);
		}

		// delete it
		$this->model->delete(['id' => $id]);

		// prove it
		if ($this->model->getRowCount()) {
			$sessionFeedback->setMessage("{$this->nameSingular} $id deleted");
			return new Response(json_encode($sessionFeedback->getMessage()));
		} else {
			$sessionFeedback->setMessage("unable to delete $id");
			return new Response(json_encode($sessionFeedback->getMessage()), 500);
		}
	}
}
