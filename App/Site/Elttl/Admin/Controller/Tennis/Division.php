<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Response;
use OriginalAppName\Registry;
use OriginalAppName\Site\Elttl\Model;
use OriginalAppName\Site\Elttl\Entity;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Division extends \OriginalAppName\Controller\Admin
{


	public $nameSingular = 'division';


	public $namePlural;


	public $nsEntity;


	public $model;


	public function __construct()
	{
		Parent::__construct();
		$this->namePlural = $this->nameSingular . 's';
		$this->nsEntity = 'OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\' . ucfirst($this->nameSingular);
		$class = 'OriginalAppName\\Site\\Elttl\\Model\\Tennis\\' . ucfirst($this->nameSingular);
		$this->model = new $class;
		$this
			->view
			->setDataKey('nameSingular', $this->nameSingular)
			->setDataKey('namePlural', $this->namePlural)
			->setDataKey('urlCreate', $this->url->generate('admin/tennis/' . $this->nameSingular . '/create'));
	}


	public function create()
	{
		$registry = Registry::getInstance();

		// new entity
		$entity = new $this->nsEntity;
		$entity->yearId = $registry->get('database/options/yearId');

		// create new Division
		$this->model->create([$entity]);

		// update
		$this->update(current($this->model->getLastInsertIds()));
	}


	public function all() {
		$registry = Registry::getInstance();
		$this->model->readColumn('yearId', $registry->get('database/options/yearId'));
		$this
			->view
			->setDataKey($this->namePlural, $this->model->getData());
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/all"));
	}


	public function single($id = 0)
	{

		// read single
		$entity = $this->model
			->readId([$id])
			->getDataFirst();

		// render
		$this
			->view
			->setDataKey('division', $entity ? $entity : new $this->nsEntity);
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/single"));
	}


	public function update($id)
	{

		// resources
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


	public function delete($id)
	{
		
		// resources
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entityDivision = $this->model
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityDivision) {
			$this->redirect("admin/tennis/{$this->nameSingular}/all");
		}

		// delete it
		$this->model->delete(['id' => $id]);

		// prove it
		if ($this->model->getRowCount()) {
			$sessionFeedback->setMessage("{$this->nameSingular} $id deleted");
			$this->redirect("admin/{$this->nameSingular}/all");
		} else {
			$sessionFeedback->setMessage("unable to delete $id");
		}
	}
}
