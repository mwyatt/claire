<?php

namespace OriginalAppName\Controller;

use OriginalAppName;
use OriginalAppName\Registry;
use OriginalAppName\Model;
use OriginalAppName\Json;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\View;
use OriginalAppName\Service;
use OriginalAppName\Response;
use OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Admin extends \OriginalAppName\Admin\Controller\Feedback
{


	public $user;


	public $permissions = [];


	public function __construct()
	{
		parent::__construct();
		$this->setPermissions();
		$this->getPermission();
		$this->defaultGlobalAdmin();
		
		$this
			->view
			->appendAsset('mustache', 'admin/feedback')
			->appendAsset('js', 'vendor/jquery')
			->appendAsset('js', 'vendor/tinymce/tinymce')
			->appendAsset('js', 'admin/common')
			->appendAsset('css', 'admin/common');
	}


	/**
	 * obtain permission from loaded permissions
	 * or redirect
	 * @return null 
	 */
	public function getPermission()
	{
		$sessionUser = new AdminSession\User;

		// must be logged in
		if (! $sessionUser->isLogged()) {
			return;
		}
		$registry = Registry::getInstance();
		$sessionFeedback = new Session\Feedback;
		$currentRoute = $registry->get('route/current');
		$entityUser = $this->getUser();

		// always allow /admin/ and unkeyed
		if ($currentRoute == 'admin' || ($currentRoute + 0) > 0 || $entityUser->email == 'martin.wyatt@gmail.com') {
			return;
		}

		// check for permission
		if (! array_key_exists($currentRoute, $this->permissions)) {
			$sessionFeedback->setMessage('you do not have permission to access that area');
			$this->redirect('admin');
		}
	}


	/**
	 * store permissions based on logged user
	 */
	public function setPermissions()
	{
		$modelPermission = new Model\User\Permission;
		$sessionUser = new AdminSession\User;
		$modelPermission
			->readColumn('userId', $sessionUser->get('id'))
			->keyDataByProperty('name');
		return $this->permissions = $modelPermission->getData();
	}


	/**
	 * store default data in view
	 * store default site date in view
	 * @return null 
	 */
	public function defaultGlobalAdmin()
	{
		$sessionUser = new AdminSession\User;
		$sessionFeedback = new Session\Feedback;

		// not logged in
		if (! $sessionUser->isLogged() && $this->url->getCurrent() != $this->url->generate('admin')) {
			$this->redirect('admin');
		}
		
		// logout
		if (array_key_exists('logout', $_REQUEST) && $sessionUser->isLogged()) {
			$sessionUser->delete();
			$sessionFeedback->setMessage('successfully logged out');
			$this->redirect('admin');
		}

		// more resource
		if ($sessionUser->isLogged()) {
			$this->readMenu();
			$this
				->view
				->setDataKey('adminUser', $this->getUser());
		}
	}


	public function getUser()
	{
		if ($this->user) {
			return $this->user;
		}
		$sessionUser = new AdminSession\User;
		$modelUser = new Model\User;
		$modelUser->readId([$sessionUser->get('id')]);
		if (! $entityUser = current($modelUser->getData())) {
			$sessionUser->delete();
			$this->redirect('admin');
		}
		$this->user = $entityUser;
		return $this->user;
	}


	public function readMenu()
	{	
		$config = include SITE_PATH . 'config' . EXT;
		if (empty($config['admin/menu'])) {
			return;
		}
		$items = [];
		foreach ($config['admin/menu'] as $item) {

			// has permission
			if (isset($this->permissions[$item['route']])) {
				$entity = new Entity\Menu;
				$entity->idParent = 0;
				$entity->keyGroup = 'admin';
				$entity->name = $item['name'];
				$entity->url = $this->view->url->generate($item['route']);
				$items[] = $entity;
			}
		}
		$menu = new OriginalAppName\Menu;
		$menu
			->setUrlAbsolute()
			->buildTree($items);
		$this
			->view
			->setDataKey('menu', $menu->getData());
	}
}
