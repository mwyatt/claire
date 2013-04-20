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
		$content = new Model_Maincontent($this->database, $this->config);
		$media = new Model_Mainmedia($this->database, $this->config);

		if (array_key_exists('form_create', $_POST)) {
			if ($id = $content->create()) {
				$media->uploadAttach($id);
				$this->route('base', 'admin/content/' . $this->config->getUrl(2) . '/?edit=' . $id);
			} else {
				$this->route('base', 'admin/content/' . $this->config->getUrl(2) . '/');
			}
		}

		if (array_key_exists('form_update', $_POST)) {
			if ($content->update()) {
				$this->route('current');
			} else {
				$this->route('current');
			}
		}

		if (array_key_exists('edit', $_GET)) {
			$content->readById($_GET['edit']);
			$this->view
				->setObject($content)
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
	