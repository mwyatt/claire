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
	}


	public function index() {
		$user = new Model_Mainuser($this->database, $this->config);
		
		if (array_key_exists('logout', $_GET)) {
			$user->logout();
			$route->homeAdmin();
		}

		if (array_key_exists('form_login', $_POST)) {
			if ($user->login()) {
				$user->setSession();
			}
			$route->home('admin/');
		}

		if ($user->isLogged()) {
			if ($config->getUrl(1)) {
				$path = BASE_PATH . 'app/controller/' . $config->getUrl(0) . '/' . $config->getUrl(1) . '.php';
				if ($user->checkPermission($path)) {
					require_once($path);
				} else {
					$this->view->loadTemplate('admin/permission');	
				}
			} else {
				$this->view->loadTemplate('admin/dashboard');	
			}	
		}

		$this->view->loadTemplate('admin/login');
	}

	public function page() {
		$page = new Model_Page($this->database, $this->config);
		$page
			->setObject($session)
			->setObject($mainUser);

		if (array_key_exists('form_page_new', $_POST)) {
			$page->create();
			$route->current();
		}

		if ($config->getUrl(2) == 'new') {
			$this->view->loadTemplate('admin/page/new');
		}
		 
		if ($config->getUrl(2))	$route->home('admin/page/');

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

		// next page

		if ($config->getUrl(2)) {

			$path = BASE_PATH . 'app/controller/admin/media/' . $config->getUrl(2) . '.php';

			if (is_file($path))
				require_once($path);
			
		}
		 
		// invalid url

		if ($config->getUrl(2))
			$route->home('admin/media/');

		// upload attempt

		if (array_key_exists('form_media_upload', $_POST)) {

			$mainMedia->upload($_FILES);
			$route->home('admin/media/');	
			
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
		// next page

		if ($config->getUrl(2)) {

			$path = BASE_PATH . 'app/controller/admin/posts/' . $config->getUrl(2) . '.php';

			if (is_file($path))
				require_once($path);
			
		}
		 
		// invalid url

		if ($config->getUrl(2))
			$route->home('admin/posts/');

		// default page

		$this->view->loadTemplate('admin/posts');
	}

	public function league() {

		// next page

		if ($config->getUrl(2)) {

			$path = BASE_PATH . 'app/controller/admin/league/' . $config->getUrl(2) . '.php';

			if (is_file($path))
				require_once($path);
			
		}
		 
		// invalid url

		if ($config->getUrl(2))
			$route->home('admin/league/');

		// default page

		$this->view->loadTemplate('admin/league');
	}

	
}
