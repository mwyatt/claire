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

class Controller_Front extends Controller
{


	public function initialise() {
		$menu = new Model_Mainmenu($this->database, $this->config);
		$menu->division();
		$this->view->setObject($menu);
	}


	public function index() {
		$press = new Model_maincontent($this->database, $this->config);
		$press->readByType('press', 3);
		$this->view
			->setObject($press)
			->loadTemplate('home');
	}


	public function player() {
		$this->load(array('front', 'player'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


	public function team() {
		$this->load(array('front', 'team'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


	public function press() {
		$this->load(array('front', 'press'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


	public function division() {
		$this->load(array('front', 'division'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


	public function page() {
		if ($this->config->getUrl(1)) {
			$page = new Model_Maincontent($this->database, $this->config);
			if (! $page->readByTitle(array($this->config->getUrl(1)))) {
				$this->route('base');
			}
			$this->view
				->setMeta(array(		
					'title' => $page->getData('title')
				))
				->setObject($page)
				->loadTemplate('page');
		}
		$this->route('base');
	}


	public function minutes() {
		$this->load(array('front', 'minutes'), $this->config->getUrl(1), $this->view, $this->database, $this->config);
	}


	public function archive() {
		$archive = new Model_Ttarchive($this->database, $this->config);
		if ($this->config->getUrl(1)) {
			$id = $this->getId($this->config->getUrl(1));
			if (! $archive->readById(array($id))) {
				$this->route('base', 'archive/');
			}
			$this->view
				->setMeta(array(		
					'title' => 'East Lancashire Table Tennis League archive'
				))
				->setObject($archive)
				->loadTemplate('archive-single');
		}
		$archive->read();
		$this->view
			->setMeta(array(		
				'title' => 'All archives'
				, 'keywords' => 'archives, archive'
				, 'description' => 'All archives in the East Lancashire Table Tennis League'
			))
			->setObject($archive)
			->loadTemplate('archive');
	}


}
