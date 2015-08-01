<?php

namespace OriginalAppName\Admin\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends \OriginalAppName\Controller\Admin
{


	public function create()
	{
		
		// resource
		$entityUser = new \OriginalAppName\Entity\User;
		$modelUser = new \OriginalAppName\Model\User;

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
		$modelUser = new \OriginalAppName\Model\User;
		$sessionFeedback = new \OriginalAppName\Session\Feedback;

		// get users
		$modelUser->read();

		// render
		$this
			->view
			->setDataKey('users', $modelUser->getData());
		return new \OriginalAppName\Response($this->view->getTemplate('admin/user/all'));
	}


	public function single($id = 0)
	{

		// resource
		$modelUser = new \OriginalAppName\Model\User;

		// read single
		$entityUser = $modelUser
			->readId([$id])
			->getDataFirst();

		// permissions
		$modelPermission = new \OriginalAppName\Model\User\Permission;
		$servicePermission = new \OriginalAppName\Admin\Service\User\Permission;
		$modelPermission
			->readColumn('userId', $id)
			->keyDataByProperty('name');
		$adminRoutes = $servicePermission->getAdminRoutes();

		// render
		$this
			->view
			->appendAsset('js', 'admin/user/single')
			->setDataKey('permissionRoutes', $adminRoutes)
			->setDataKey('permissions', $modelPermission->getData())
			->setDataKey('user', $entityUser ? $entityUser : new \OriginalAppName\Entity\User);
		return new \OriginalAppName\Response($this->view->getTemplate('admin/user/single'));
	}


	public function update($id)
	{

		// resources
		$sessionFeedback = new \OriginalAppName\Session\Feedback;
		$modelUser = new \OriginalAppName\Model\User;

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
			->setNameLast($_POST['user']['nameLast']);

		// remove all permissions then add the ones selected
		$modelPermission = new \OriginalAppName\Model\User\Permission;
		$modelPermission->deleteUserId($id);
		$entitiesPermission = [];
		if (! empty($_POST['user']['permission'])) {
			foreach ($_POST['user']['permission'] as $route) {
				$entityPermission = new \OriginalAppName\Entity\User\Permission;
				$entityPermission->userId = $id;
				$entityPermission->name = $route;
				$entitiesPermission[] = $entityPermission;
			}
			$modelPermission->create($entitiesPermission);
		}

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
		$this->redirect('admin/user/single', ['id' => $entityUser->getId()]);
	}


	public function delete($id)
	{
		
		// resources
		$modelUser = new \OriginalAppName\Model\User;
		$sessionFeedback = new \OriginalAppName\Session\Feedback;

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
