<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Entity;
use OriginalAppName\Model;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\View;
use OriginalAppName\Service;
use OriginalAppName\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Controller\Admin
{


	public function create($type)
	{
		
		// resource
		$entityContent = new Entity\Content;
		$modelContent = new Model\Content;
		$sessionUser = new AdminSession\User;

		// create new content
		$entityContent
			->setType($type)
			->setTimePublished(time())
			->setUserId($sessionUser->get('id'));
		$modelContent->create([$entityContent]);

		// update
		$this->update($type, current($modelContent->getLastInsertIds()));
	}


	/**
	 * content list
	 * @return object Response
	 */
	public function all($type) {
		
		// resource
		$modelContent = new Model\Content;
		$modelContent->readColumn('type', $type);

		// render
		$this
			->view
			->setDataKey('contents', $modelContent->getData())
			->setDataKey('contentType', $type);
		return new Response($this->view->getTemplate('admin/content/all'));
	}


	public function single($type, $id = 0)
	{

		// resource
		$modelContent = new Model\Content;

		// read single
		$entityContent = $modelContent
			->readId([$id])
			->getDataFirst();

		// render
		$this
			->view
			->setDataKey('content', $entityContent ? $entityContent : new Entity\Content);
		return new Response($this->view->getTemplate('admin/content/single'));
	}


	public function update($id)
	{

		// resources
		$sessionFeedback = new Session\Feedback;
		$modelContent = new Model\Content;

		// load 1
		$entityContent = $modelContent
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityContent) {
			$this->redirect('admin/content/all');
		}

		// merge
		$entityContent->consumeArray($_POST['content']);

		// update
		$modelContent->update($entityContent, ['id' => $id]);

		// feedback
		$sessionFeedback->setMessage("content $id saved", 'positive');

		// redirect
		$this->redirect('admin/content/single', ['type' => $entityContent->getType(), 'id' => $id]);
	}


	public function delete($id)
	{

		// resources
		$modelContent = new Model\Content;
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entityContent = $modelContent
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityContent) {
			$this->redirect('admin/content/all');
		}

		// delete it
		$modelContent->delete(['id' => $id]);

		// prove it
		if ($modelContent->getRowCount()) {
			$sessionFeedback->setMessage("content $id deleted");
			$this->redirect('admin/content/all');
		} else {
			$sessionFeedback->setMessage("unable to delete $id");
		}
	}
}
