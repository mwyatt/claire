<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\Registry;
use OriginalAppName\Model;
use OriginalAppName\Session;
use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Admin
{


	public function admin($request)
	{
		$sessionUser = new AdminSession\User;
		$sessionForm = new Session\Form;
		$sessionUrlHistory = new Session\UrlHistory;

		// login attempt
		if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
			
			// store attempt
			$sessionForm->set('admin\login', [
				'email' => $_REQUEST['email']
			]);

			// attempt login
			$serviceUser = new \OriginalAppName\Admin\Service\User;
			$serviceUser->login($_REQUEST['email'], $_REQUEST['password']);

			// route to admin
			return $this->route('admin');
		}

		// test if logged in
		if ($sessionUser->isLogged()) {
			return $this->dashboard();
		}
		return $this->formLogin();
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
			$this->route('admin');
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
			->setDataKey('sessionForm', $sessionForm->pull('admin\login'));
		return new Response($this->view->getTemplate('admin/login'));
	}
}
