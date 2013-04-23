<?php

/**
 * admin
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Admin extends Controller
{


	public function initialise() {
		$user = new Model_Mainuser($this->database, $this->config);

		if (array_key_exists('logout', $_GET)) {
			$user->logout();
			$this->session->set('feedback', 'Successfully logged out');
			$this->route('base', 'admin/');
		}

		if (array_key_exists('form_login', $_POST)) {
			if ($user->login($_POST['email_address'], $_POST['password'])) {
				$this->session->set('feedback', 'Successfully Logged in as ' . $this->session->get('user', 'first_name') . ' ' . $this->session->get('user', 'last_name'));
				$this->route('base', 'admin/');
			}
			$this->session->set('feedback', 'Email Address or password incorrect');
			$this->session->set('form_field', array('email' => $_POST['email_address']));
			$this->route('base', 'admin/');
		}

		if ($user->isLogged()) {
			$user->setData($user->get());
			$this->view->setObject($user);
		} else {
			if ($this->config->getUrl(1)) {
				$this->route('base', 'admin/');
			}
			$this->view->loadTemplate('admin/login');
		}
	}


	/**
	 * dashboard of admin area, displays login until logged in, then dashboard
	 */
	public function index() {
		$this->view->loadTemplate('admin/dashboard');		
		// $user = new Model_Mainuser($this->database, $this->config);
		// if ($user->isLogged()) {			
		// 	$user->setData($user->get());
		// 	$this->view->setObject($user);
		// } else {
		// 	$this->view->loadTemplate('admin/login');
		// }
	}


	public function content() {
		$this->load(array('admin', 'content'), $this->config->getUrl(2));
	}

	// public function media() {
	// 	if (array_key_exists('form_create', $_POST)) {
	// 		$this->create();
	// 		header("Location: " . '?m=Admin_Modules_Technologies&create=true');
	// 	}
	// 	if (array_key_exists('form_update', $_POST)) {
	// 		$this->update($_GET['update']);
	// 		header("Location: " . '?m=Admin_Modules_Technologies');
	// 	}
	// 	if (array_key_exists('delete', $_GET)) {
	// 		$this->delete($_GET['delete']);
	// 		header("Location: " . '?m=Admin_Modules_Technologies');
	// 	}
	// 	if (array_key_exists('create', $_GET)) {
	// 		$this->pageCreate();
	// 	} else {
	// 		if (array_key_exists('update', $_GET)) {
	// 			$this->pageUpdate($_GET['update']);
	// 		} else {
	// 			$this->pageRead();
	// 		}
	// 	}
	// }

	// public function posts() {
	// 	// exit('under construction');
		 
	// 	// // initialise 
	// 	// $post = new Post($database, $config);
	// 	// $post
	// 	// 	->setObject($session)
	// 	// 	->setObject($mainUser);

	// 	// // next page
	// 	// if ($config->getUrl(3)) {
	// 	// 	$view->loadTemplate('admin/posts/press/new');
	// 	// }

	// 	// // invalid url
	// 	// if ($config->getUrl(3))
	// 	// 	$route->home('admin/' . $config->getUrl(1) . '/');

	// 	// // view 	
	// 	// $post->readByType('press');

	// 	// $view
	// 	// 	->setObject($post)
	// 	// 	->loadTemplate('admin/posts/press/list');

	// 	// // $this->view->loadTemplate('admin/posts');
	// }


	/**
	 * ports to new controller
	 * @todo build in functionality to do this automatically?
	 */
	public function league() {
		$this->load(array('admin', 'league'), $this->config->getUrl(2));
	}

	
}
