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

class Controller_Admin_Content extends Controller
{


	public function initialise() {
		echo '<pre>';
		print_r($_FILES);
		print_r($_POST);
		echo '</pre>';
		exit();

		$maincontent = new Model_Maincontent($this->database, $this->config);

		if (! empty($_FILES)) {
			echo '<pre>';
			print_r('variable');
			echo '</pre>';
			exit;
			
		}

		if (array_key_exists('form_create', $_POST)) {
			if ($id = $maincontent->create()) {
				$this->route('base', 'admin/content/' . $this->config->getUrl(2) . '/?edit=' . $id);
			} else {
				$this->route('base', 'admin/content/' . $this->config->getUrl(2) . '/');
			}
		}

		if (array_key_exists('form_update', $_POST)) {
			if ($maincontent->update()) {
				$this->route('current');
			} else {
				$this->route('current');
			}
		}

		if (array_key_exists('edit', $_GET)) {
			$maincontent->readById($_GET['edit']);
			$this->view
				->setObject($maincontent)
				->loadTemplate('admin/content/create-update');
		}

		if ($this->config->getUrl(3) == 'new') {
			$this->view->loadTemplate('admin/content/create-update');
		}
	}


	public function index() {
		$this->view->loadTemplate('admin/dashboard');
	}


	public function page() {
		$page = new Model_Maincontent($this->database, $this->config);
		$page->readByType($this->config->getUrl(2));
		$this->view
			->setObject($page)
			->loadTemplate('admin/content/list');
	}


	public function minutes() {
		$page = new Model_Maincontent($this->database, $this->config);
		$page->readByType($this->config->getUrl(2));
		$this->view
			->setObject($page)
			->loadTemplate('admin/content/list');
	}


	public function press() {
		$page = new Model_Maincontent($this->database, $this->config);
		$page->readByType($this->config->getUrl(2));
		$this->view
			->setObject($page)
			->loadTemplate('admin/content/list');
	}
}
	