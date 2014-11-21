<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
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
		$sessionUser = new Session\Admin\User;
		$sessionForm = new Session\Form;
		$sessionFeedback = new Session\Feedback;
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
			$this->route($sessionUrlHistory->getLatest());
		}

		// test if logged in
		if ($sessionUser->isLogged()) {
			return $this->adminLoggedIn();
		}
		return $this->adminLoggedOut();
	}


	public function adminLoggedIn()
	{
		if (! $modelUser->read(array('where' => array('id' => $sessionAdminUser->getData('id'))))) {
			$this->route('admin');
		}
		$this->view->setDataKey('user', $modelUser->getDataFirst());

		echo '<pre>';
		print_r('dashboard');
		echo '</pre>';
		exit;
		return $this->view->getTemplate('admin/dashboard');
		
	}


	public function adminLoggedOut()
	{
		$sessionForm = new Session\Form;

		// template
		$this
			->view
			->setDataKey('sessionForm', $sessionForm->getData());
		return new Response($this->view->getTemplate('admin\login'));
	}
}
