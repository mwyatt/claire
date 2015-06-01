<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\Registry;
use OriginalAppName\Model;
use OriginalAppName\Session;
use OriginalAppName\View;
use OriginalAppName\Service;
use OriginalAppName\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Admin
{


	public function admin()
	{
		$sessionUser = new AdminSession\User;
		$sessionUrlHistory = new Session\UrlHistory;

		// test if logged in
		if ($sessionUser->isLogged()) {
			return $this->dashboard();
		}
		return $this->formLogin();
	}


	public function login()
	{
		$sessionForm = new Session\Form;
		
		// store attempt
		$sessionForm->set('admin\login', [
			'email' => $_REQUEST['email']
		]);

		// attempt login
		$serviceUser = new \OriginalAppName\Admin\Service\User;
		$serviceUser->login($_REQUEST['email'], $_REQUEST['password']);

		// route to admin
		return $this->redirect('admin');
	}


	public function dashboard()
	{

		// resource
		$sessionUser = new AdminSession\User;
		$modelUser = new Model\User;

		// find user by id
		$modelUser->readId([$sessionUser->get('id')]);
		if (! $entityUser = $modelUser->getDataFirst()) {
			$sessionUser->delete();
			$this->redirect('admin');
		}

		// template
		$this
			->view
			->setDataKey('moduleName', 'dashboard')
			->setDataKey('user', $entityUser);
		return new Response($this->view->getTemplate('admin/dashboard'));
		
	}


	public function formLogin()
	{
		$sessionForm = new Session\Form;

		// template
		$this
			->view
			->setDataKey('moduleName', 'login')
			->appendAsset('css', 'admin/login')
			->setDataKey('sessionForm', $sessionForm->pull('admin\login'));
		return new Response($this->view->getTemplate('admin/login'));
	}
}
