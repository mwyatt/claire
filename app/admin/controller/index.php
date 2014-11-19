<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller
{


	/**
	 * custom for admin defaults
	 */
	public function __construct()
	{

		// first
		Parent::__construct();

		// second
		$this->defaultAdminGlobal();
	}


	public function admin($request)
	{
		$sessionUser = new \OriginalAppName\Session\Admin\User('OriginalAppName\Session\Admin\User');
		$sessionFeedback = new OriginalAppName\Session\Admin\Feedback();

		if (array_key_exists('logout', $_REQUEST) && $sessionUser->isLogged()) {
			$this->logout();
		}
	}


	public function logout()
	{
		$sessionUser = new \OriginalAppName\Session\Admin\User('OriginalAppName\Session\Admin\User');
		$sessionFeedback = new OriginalAppName\Session\Admin\Feedback();
		$sessionUser->delete();
		$sessionFeedback->set('successfully logged out');
		$this->route('admin');
	}


	public function defaultAdminGlobal()
	{

		$sessionUser = new \OriginalAppName\Session\Admin\User('OriginalAppName\Session\Admin\User');
		if (! $sessionUser->isLogged()) {
			$this->route('admin');
		}
		$this->readMenu();
		$this->readUser();
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
		$sessionFormfield = new session_formfield($this);
		$sessionHistory = new session_history($this);
		$this->view->setObject('user', false);


		$this->view
			->setObject($sessionFormfield);

		// logging in
		if (array_key_exists('login', $_POST)) {

			// remember form field
			$sessionFormfield->add($_POST, array('login_email', 'login_password'));

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
			$this->view->setObject('user', $modelUser->getDataFirst());
		} else {
			if ($this->url->getPathPart(1)) {
				$sessionHistory->setCaptureUrl($this->url->getCache('current'));
				$this->route('admin');
			}
			return $this->view->getTemplate('admin/login');
		}
		return $this->view->getTemplate('admin/dashboard');
	}


	public function readUser()
	{
		$sessionUser = new \OriginalAppName\Session\Admin\User('OriginalAppName\Session\Admin\User');
		$modelUser = new model_user();
		$modelUser->readId([$sessionUser->get('id')])
		if (! $entityUser = current($modelUser->getData())) {
			$sessionUser->delete();
			$this->route('admin');
		}
		$this
			->view
			->mergeData(['user', $entityUser]);
	}


	public function readMenu()
	{
		$json = new \OriginalAppName\Json($this);
		$json->read('admin/menu');
		$this
			->view
			->mergeData(['menu', $json->getData()]);
	}
}
