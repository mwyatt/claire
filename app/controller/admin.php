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
		$user = new Model_Mainuser($this->database, $this->config);
		if ($user->isLogged()) {			
			$user->setData($user->get());
			$this->view->setObject($user);
			$this->view->loadTemplate('admin/dashboard');		
		} else {
			$this->view->loadTemplate('admin/login');
		}
	}


	/**
	 * general page mangement, complete crud
	 */
	public function page() {
		$user = new Model_Mainuser($this->database, $this->config);
		$session = new Session($this->database, $this->config);
		$page = new Model_Page($this->database, $this->config);
		$mainContent = new Model_Maincontent($this->database, $this->config);
		$page->setObject($session)->setObject($user);

		if (array_key_exists('form_create', $_POST)) {
			if ($id = $page->create()) {
				$this->route('base', 'admin/page/?edit=' . $id);
			} else {
				$this->route('base', 'admin/page/');
			}
		}

		if (array_key_exists('form_update', $_POST)) {
			if ($page->update()) {
				$this->route('current');
			} else {
				$this->route('current');
			}
		}

		if (array_key_exists('edit', $_GET)) {
			$mainContent->readById($_GET['edit']);
			$this->view
				->setObject($mainContent)
				->loadTemplate('admin/page/create-update');
		}

		if ($this->config->getUrl(2) == 'new') {
			$this->view->loadTemplate('admin/page/create-update');
		}
		 
		if ($this->config->getUrl(2)) {
			$this->config->getObject('route')->home('admin/page/');
		}

		$mainContent->readByType('page');

		$this->view
			->setObject($mainContent)
			->loadTemplate('admin/page');
	}

	public function media() {
		// exit('under construction');
		// // initialise 

		// $mainMedia = new Model_Mainmedia($this->database, $this->config);
		// $mainMedia
		// 	->setObject($this->view)
		// 	->setObject($session)
		// 	->setObject($mainUser);

 
		// // invalid url

		// if ($this->config->getUrl(2))
		// 	$this->config->getObject('route')->home('admin/media/');

		// // upload attempt

		// if (array_key_exists('form_media_upload', $_POST)) {

		// 	$mainMedia->upload($_FILES);
		// 	$this->config->getObject('route')->home('admin/media/');	
			
		// }

		// // (GET) delete

		// if (array_key_exists('delete', $_GET)) {
			
		// 	$mainMedia->deleteById($_GET['delete']);
				
		// }
		  
		// $mainMedia->read();

		// $this->view
		// 	->setObject($mainMedia)
		// 	->loadTemplate('admin/media/list');

	}

	public function posts() {
		// exit('under construction');
		 
		// // initialise 
		// $post = new Post($database, $config);
		// $post
		// 	->setObject($session)
		// 	->setObject($mainUser);

		// // next page
		// if ($config->getUrl(3)) {
		// 	$view->loadTemplate('admin/posts/press/new');
		// }

		// // invalid url
		// if ($config->getUrl(3))
		// 	$route->home('admin/' . $config->getUrl(1) . '/');

		// // view 	
		// $post->readByType('press');

		// $view
		// 	->setObject($post)
		// 	->loadTemplate('admin/posts/press/list');

		// // $this->view->loadTemplate('admin/posts');
	}


	/**
	 * ports to new controller
	 * @todo build in functionality to do this automatically?
	 */
	public function league() {
		$this->load(array('admin', 'league'));
	}

	
}
