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


	/**
	 * dashboard of admin area, displays login until logged in, then dashboard
	 */
	public function index() {
		$user = new Model_Mainuser($this->database, $this->config);
		$user->setObject($this->config->getObject('session'));
		
		if (array_key_exists('logout', $_GET)) {
			$user->logout();
			$this->config->getObject('route')->homeAdmin();
		}

		if (array_key_exists('form_login', $_POST)) {
			if ($user->login()) {
				$user->setSession();
			}
			$this->config->getObject('route')->home('admin/');
		}

		$this->view->setObject($user);

		if ($user->isLogged()) {
			$this->view->loadTemplate('admin/dashboard');		
		}

		$this->view->loadTemplate('admin/login');
	}


	/**
	 * general page mangement, complete crud
	 */
	public function page() {
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
		
		 
		// invalid url

		if ($this->config->getUrl(2))
			$this->config->getObject('route')->home('admin/posts/');

		// default page

		$this->view->loadTemplate('admin/posts');
	}

	public function league() {
		$user = new Model_Mainuser($this->database, $this->config);
		$user->setObject($this->config->getObject('session'));
		$this->view->setObject($user);
		if (array_key_exists('page', $_GET)) {
			$this->view->loadTemplate('admin/league/' . $_GET['page']);
		}
		$this->view->loadTemplate('admin/league');
	}

	
}
