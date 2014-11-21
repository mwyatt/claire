<?php

namespace OriginalAppName\Admin\Controller;

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

		// login attempt
		if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
			
			// store attempt
			$sessionForm->set('admin\login', [
				'email' => $_REQUEST['email']
			]);

			// attempt login
			$serviceUser = \OriginalAppName\Admin\Serivce\User;
			$serviceUser->login($_REQUEST['email'], $_REQUEST['password']);
			$this->route(sessiohistory last stored url);
		}

		// template
		$this
			->view
			->setDataKey('sessionForm', $sessionForm->getData());

		// test if logged in
		if ($sessionUser->isLogged()) {
			return $this->adminLoggedIn();
		}
		return $this->adminLoggedOut();
	}


	public function adminLoggedIn()
	{
		echo '<pre>';
		print_r('dashboard');
		echo '</pre>';
		exit;
		
	}


	public function adminLoggedOut()
	{
		$sessionFeedback = new Session\Feedback;
		$this
			->view
			->setDataKey('feedback', $sessionFeedback->pull('message'));
		return new Response($this->view->getTemplate('admin\login'));
	}


	/**
	 * @todo test session handling here
	 * @todo feedback should be its own session module
	 * @todo ensure you build in session_history to visit the
	 *       url you intend to after logging in
	 */
	public function run() {
		$modelUser = new model_user($this);
		$sessionAdminUser = new session_admin_user($this);
		$sessionFeedback = new session_feedback($this);
		$sessionHistory = new session_history($this);
		$this->view->setDataKey('user', false);




		// logging in
		if (array_key_exists('login', $_POST)) {

			// remember form field


			// user exists
			$modelUser->read(array('where' => array('email' => $_POST['login_email'])));
			if (! $modelUser->getData()) {
				$sessionFeedback->set('Email address does not exist');
				$this->route('admin');
			}

			// validate password
			if (! $modelUser->validatePassword($_POST['login_password'])) {
				$sessionFeedback->set('Password incorrect');
				$this->route('admin');
			}

			// the mold
			$mold = $modelUser->getDataFirst();

			// login
			$sessionAdminUser->login($mold);
			$sessionFeedback->set('Successfully Logged in as ' . $mold->email);
				
			// send off to captured url
			if ($sessionHistory->getCaptureUrl()) {
				$this->route($sessionHistory->getCaptureUrl());
			} else {
				$this->route('admin');
			}
		}

		// is logged in?
		if ($sessionAdminUser->isLogged()) {
			if (! $modelUser->read(array('where' => array('id' => $sessionAdminUser->getData('id'))))) {
				$this->route('admin');
			}
			$this->view->setDataKey('user', $modelUser->getDataFirst());
		} else {
			if ($this->url->getPathPart(1)) {
				$sessionHistory->setCaptureUrl($this->url->getCache('current'));
				$this->route('admin');
			}
			return $this->view->getTemplate('admin/login');
		}
		return $this->view->getTemplate('admin/dashboard');
	}
}
