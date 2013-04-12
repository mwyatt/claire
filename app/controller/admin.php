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
		$user->setObject($this->config->getObject('session'));
		$this->view->setObject($user);

		if (array_key_exists('logout', $_GET)) {
			$user->logout();
			$this->route('base', 'admin/');
		}

		if (array_key_exists('form_login', $_POST)) {
			if ($user->login()) {
				$user->setSession();
			}

			$this->route('base', 'admin/');
		}

		if (! $user->isLogged()) {
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
		$this->view->setObject($this->getObject('model_mainuser'));

		if ($this->getObject('model_mainuser')->isLogged()) {
			$this->view->loadTemplate('admin/dashboard');		
		} else {
			$this->view->loadTemplate('admin/login');
		}
	}


	/**
	 * general page mangement, complete crud
	 */
	public function page() {
		exit('under construction');

		$user = new Model_Mainuser($this->database, $this->config);

		if (! $user->checkPermission($path)) {
			$this->view->loadTemplate('admin/permission');	
		}

		$page = new Model_Page($this->database, $this->config);
		$page
			->setObject($session)
			->setObject($mainUser);

		if (array_key_exists('form_page_new', $_POST)) {
			$page->create();
			$this->config->getObject('route')->current();
		}

		if ($this->config->getUrl(2) == 'new') {
			$this->view->loadTemplate('admin/page/new');
		}
		 
		if ($this->config->getUrl(2))	$this->config->getObject('route')->home('admin/page/');

		$mainContent = new Model_Maincontent($this->database, $this->config);
		$mainContent->readByType('page');

		$this->view
			->setObject($mainContent)
			->loadTemplate('admin/page');
	}

	public function media() {
		exit('under construction');
		// initialise 

		$mainMedia = new Model_Mainmedia($this->database, $this->config);
		$mainMedia
			->setObject($this->view)
			->setObject($session)
			->setObject($mainUser);

 
		// invalid url

		if ($this->config->getUrl(2))
			$this->config->getObject('route')->home('admin/media/');

		// upload attempt

		if (array_key_exists('form_media_upload', $_POST)) {

			$mainMedia->upload($_FILES);
			$this->config->getObject('route')->home('admin/media/');	
			
		}

		// (GET) delete

		if (array_key_exists('delete', $_GET)) {
			
			$mainMedia->deleteById($_GET['delete']);
				
		}
		  
		$mainMedia->read();

		$this->view
			->setObject($mainMedia)
			->loadTemplate('admin/media/list');

	}

	public function posts() {
		exit('under construction');
		 
		// initialise 
		$post = new Post($database, $config);
		$post
			->setObject($session)
			->setObject($mainUser);

		// next page
		if ($config->getUrl(3)) {
			$view->loadTemplate('admin/posts/press/new');
		}

		// invalid url
		if ($config->getUrl(3))
			$route->home('admin/' . $config->getUrl(1) . '/');

		// view 	
		$post->readByType('press');

		$view
			->setObject($post)
			->loadTemplate('admin/posts/press/list');

		// $this->view->loadTemplate('admin/posts');
	}


	/**
	 * ports to new controller
	 * @todo build in functionality to do this automatically?
	 */
	public function league() {
		$controller = new Controller_Admin_League($this->database, $this->config);
		if (array_key_exists('page', $_GET)) {
			$controller->loadMethod($_GET['page']);
		} else {
			$controller->loadMethod('index');
		}
	}

	
}
	