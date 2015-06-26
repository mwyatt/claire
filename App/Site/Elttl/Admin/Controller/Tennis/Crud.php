<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Registry;
use OriginalAppName\Response;
use OriginalAppName\Session;


/**
 * attempt at making all tennis controllers share common functionality
 * then updating and patching will be easier and
 * outcomes will be more predictable
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Crud extends \OriginalAppName\Controller\Admin
{


	/**
	 * get current season rows
	 * @var int
	 */
	public $yearId;


	/**
	 * eg team
	 * @var string
	 */
	public $nameSingular;


	/**
	 * eg teams
	 * @var string
	 */
	public $namePlural;


	/**
	 * entity\path
	 * @var string
	 */
	public $nsEntity;


	/**
	 * @var object
	 */
	public $model;


	/**
	 * get vars setup and namespaces correct
	 * set any global data keys and assets
	 */
	public function __construct()
	{
		Parent::__construct();

		// naming vars and namespaces
		$registry = Registry::getInstance();
		$namespace = explode('\\', get_class($this));
		$this->nameSingular = strtolower(array_pop($namespace));
		$this->namePlural = $this->nameSingular . 's';
		$this->nsEntity = 'OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\' . ucfirst($this->nameSingular);
		$class = 'OriginalAppName\\Site\\Elttl\\Model\\Tennis\\' . ucfirst($this->nameSingular);
		$this->model = new $class;
		$this->yearId = $registry->get('database/options/yearId');
		$this
			->view
			->appendAsset('js', 'admin/tennis/common')
			->setDataKey('nameSingular', $this->nameSingular)
			->setDataKey('namePlural', $this->namePlural)
			->setDataKey('urlCreate', $this->url->generate('admin/tennis/' . $this->nameSingular . '/create'));
	}


	/**
	 * usual create routine
	 * @return null 
	 */
	public function create()
	{
		$entity = new $this->nsEntity;
		$entity->yearId = $this->yearId;

		// create new
		$this->model->create([$entity]);

		// update
		$this->update(current($this->model->getLastInsertIds()));
	}


	/**
	 * usual all routine
	 * @return object 
	 */
	public function all() {
		$this
			->model
			->readColumn('yearId', $this->yearId);
		$this
			->view
			->setDataKey($this->namePlural, $this->model->getData());
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/all"));
	}


	/**
	 * usual single routine
	 * @param  integer $id 
	 * @return object      
	 */
	public function single($id = 0)
	{
		$entity = $this->model
			->readId([$id])
			->getDataFirst();

		// render
		$this
			->view
			->setDataKey($this->nameSingular, $entity ? $entity : new $this->nsEntity);
		return new Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/single"));
	}


	public function update($id)
	{}


	/**
	 * ajax because it is the only way i can do a delete request?
	 * can be shared across
	 * @param  int $id 
	 * @return object     response
	 */
	public function delete($id)
	{
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entity = $this->model
			->readYearColumn('id', $id)
			->getDataFirst();

		// does not exist
		if (! $entity) {
			return new Response('', 404);
		}

		// delete it
		$this->model->deleteYear([$id]);

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
