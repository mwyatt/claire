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


	public function __construct()
	{
		Parent::__construct();
		$singular = 'division';
		$this
			->view
			->setDataKey('pageSingular', $singular)
			->setDataKey('pagePlural', $singular . 's')
			->setDataKey('urlCreate', $this->url->generate('admin/tennis/' . $singular . '/create'));
	}


	public function create()
	{
	echo '<pre>';
		print_r('variable');
		echo '</pre>';
		exit;
			
		// resource
		$entityDivision = new Entity\Tennis\Division;
		$modelDivision = new Model\Tennis\Division;

		// create new Division
		$modelDivision->create([$entityDivision]);

		// update
		$this->update(current($modelDivision->getLastInsertIds()));
	}


	public function all() {
		$registry = Registry::getInstance();
		$modelDivision = new Model\Tennis\Division;
		$modelDivision->readColumn('yearId', $registry->get('database/options/yearId'));
		$this
			->view
			->setDataKey('divisions', $modelDivision->getData());
		return new Response($this->view->getTemplate('admin/tennis/division/all'));
	}


	public function single($id = 0)
	{

		// resource
		$modelDivision = new Model\Tennis\Division;

		// read single
		$entityDivision = $modelDivision
			->readId([$id])
			->getDataFirst();

		// render
		$this
			->view
			->setDataKey('division', $entityDivision ? $entityDivision : new Entity\Tennis\Division);
		return new Response($this->view->getTemplate('admin/tennis/division/single'));
	}


	public function update($id)
	{

		// resources
		$sessionFeedback = new Session\Feedback;
		$modelDivision = new Model\Tennis\Division;

		// load 1
		$entityDivision = $modelDivision
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityDivision) {
			$this->redirect('admin/Division/all');
		}

		// consume post
		$entityDivision
			->setEmail($_POST['Division']['email'])
			->setNameFirst($_POST['Division']['nameFirst'])
			->setNameLast($_POST['Division']['nameLast'])
			->setLevel($_POST['Division']['level']);

		// optional
		if (! $entityDivision->getTimeRegistered()) {
			$entityDivision->setTimeRegistered(time());
		}
		if ($_POST['Division']['password']) {
			$entityDivision->setPassword($_POST['Division']['password']);
		}

		// save
		$modelDivision->update($entityDivision, ['id' => $entityDivision->getId()]);

		// feedback / route
		$sessionFeedback->setMessage("Division $id saved", 'positive');
		$this->redirect('admin/tennis/division/single', ['id' => $entityDivision->getId()]);
	}


	public function delete($id)
	{
		
		// resources
		$modelDivision = new Model\Tennis\Division;
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entityDivision = $modelDivision
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityDivision) {
			$this->redirect('admin/tennis/division/all');
		}

		// delete it
		$modelDivision->delete(['id' => $id]);

		// prove it
		if ($modelDivision->getRowCount()) {
			$sessionFeedback->setMessage("Division $id deleted");
			$this->redirect('admin/Division/all');
		} else {
			$sessionFeedback->setMessage("unable to delete $id");
		}
	}
}
