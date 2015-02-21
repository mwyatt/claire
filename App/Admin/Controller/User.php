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
class User extends \OriginalAppName\Controller\Admin
{


	public function create($type)
	{
		
		// resource
		$entityUser = new Entity\User;
		$modelUser = new Model\User;

		// create new User
		$entityUser
			->setTimeRegistered(time());
		$modelUser->create([$entityUser]);

		// update
		$this->update(current($modelUser->getLastInsertIds()));
	}


	/**
	 * User list
	 * @return object Response
	 */
	public function all() {
		
		// resource
		$modelUser = new Model\User;
		$sessionFeedback = new Session\Feedback;

		// get users
		$modelUser->read();

		// render
		$this
			->view
			->setDataKey('users', $modelUser->getData());
		return new Response($this->view->getTemplate('admin/user/all'));
	}


	public function single($id = 0)
	{

		// resource
		$modelUser = new Model\User;

		// read single
		$entityUser = $modelUser
			->readId([$id])
			->getDataFirst();

		// render
		$this
			->view
			->setDataKey('user', $entityUser ? $entityUser : new Entity\User);
		return new Response($this->view->getTemplate('admin/user/single'));
	}


	public function update($id)
	{

		// resources
		$sessionFeedback = new Session\Feedback;
		$modelUser = new Model\User;

		// load 1
		$entityUser = $modelUser
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityUser) {
			$this->redirect('admin/user/all');
		}

		// consume post
		$entityUser
			->setEmail($_POST['user']['email'])
			->setNameFirst($_POST['user']['nameFirst'])
			->setNameLast($_POST['user']['nameLast'])
			->setLevel($_POST['user']['level']);

		// optional
		if (! $entityUser->getTimeRegistered()) {
			$entityUser->setTimeRegistered(time());
		}
		if ($_POST['user']['password']) {
			$entityUser->setPassword($_POST['user']['password']);
		}

		// save
		$modelUser->update($entityUser, ['id' => $entityUser->getId()]);

		// feedback / route
		$sessionFeedback->setMessage("user $id saved", 'positive');
		$this->redirect('adminUserSingle', ['id' => $entityUser->getId()]);
	}


	public function delete($id)
	{
		
		// resources
		$modelUser = new Model\User;
		$sessionFeedback = new Session\Feedback;

		// load 1
		$entityUser = $modelUser
			->readId([$id])
			->getDataFirst();

		// does not exist
		if (! $entityUser) {
			$this->redirect('admin/user/all');
		}

		// delete it
		$modelUser->delete(['id' => $id]);

		// prove it
		if ($modelUser->getRowCount()) {
			$sessionFeedback->setMessage("user $id deleted");
			$this->redirect('admin/user/all');
		} else {
			$sessionFeedback->setMessage("unable to delete $id");
		}
	}
}
