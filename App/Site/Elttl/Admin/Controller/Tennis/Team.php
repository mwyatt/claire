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
			->readYearColumn('id', $id)
			->getDataFirst();
		$modelPlayer = new Model\Tennis\Player;
		$modelPlayer
			->readColumn('yearId', $this->yearId)
			->orderByProperty('nameLast');
		$modelVenue = new Model\Tennis\Venue;
		$modelVenue
			->readColumn('yearId', $this->yearId)
			->orderByProperty('name');
		$modelDivision = new Model\Tennis\Division;
		$modelDivision
			->readColumn('yearId', $this->yearId);

		// render
		$this
			->view
			->setDataKey('divisions', $modelDivision->getData())
			->setDataKey('venues', $modelVenue->getData())
			->setDataKey('players', $modelPlayer->getData())
			->setDataKey('weekdays', $this->model->getWeekdays())
			->setDataKey($this->nameSingular, $entity ? $entity : new $this->nsEntity);
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/single"));
	}


	public function update($id)
	{	
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entity = $this->model
			->readYearColumn('id', $id)
			->getDataFirst();

		// does not exist
		if (! $entity) {
			$this->redirect("admin/tennis/{$this->nameSingular}/all");
		}

		// consume post
		$entity->name = $_POST['entity']['name'];
		$entity->slug = $_POST['entity']['slug'];
		$entity->homeWeekday = $_POST['entity']['homeWeekday'];
		$entity->secretaryId = $_POST['entity']['secretaryId'];
		$entity->venueId = $_POST['entity']['venueId'];
		$entity->divisionId = $_POST['entity']['divisionId'];

		// save
		$this->model->update($entity, ['id' => $entity->getId(), 'yearId' => $registry->get('database/options/yearId')]);

		// feedback / route
		$sessionFeedback->setMessage("$this->nameSingular $id saved", 'positive');
		$this->redirect("admin/tennis/{$this->nameSingular}/single", ['id' => $entity->getId()]);
	}
}
