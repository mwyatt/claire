<?php

namespace OriginalAppName\Controller;

use OriginalAppName;
use OriginalAppName\Model;
use OriginalAppName\Json;
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
class Admin extends \OriginalAppName\Admin\Controller\Feedback
{


	public function __construct()
	{
		parent::__construct();
		$this->defaultGlobalAdmin();
		$this->view->appendAsset('css', 'admin/common');
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
			$this->readUser();
		}
	}


	public function readUser()
	{
		$sessionUser = new AdminSession\User;
		$modelUser = new Model\User;
		$modelUser->readId([$sessionUser->get('id')]);
		if (! $entityUser = current($modelUser->getData())) {
			$sessionUser->delete();
			$this->redirect('admin');
		}
		$this
			->view
			->setDataKey('adminUser', $entityUser);
	}


	public function readMenu()
	{
	
		// menu primary
		$modelMenu = new Model\Menu;
		$modelMenu->readColumn('keyGroup', 'admin');
		$menu = new OriginalAppName\Menu;
		$menu->buildTree($modelMenu->getData());
		$this
			->view
			->setDataKey('menu', $menu->getData());
	}
}
