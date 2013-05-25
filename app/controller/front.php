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
		if (array_key_exists('search', $_GET)) {
			$this->search($_GET['search']);
		}
	}


	public function index() {
		$press = new Model_maincontent($this->database, $this->config);
		$press->readByType('press', 3);
		$this->view
			->setObject($press)
			->loadTemplate('home');
	}


	public function search($query) {
		$search = new Model_Search($this->database, $this->config);
		$search->read($query);
		$this->view
			->setObject('search_query', $query)
			->setObject($search)
			->loadTemplate('search');
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


	public function tablesAndResults() {
		$division = new Model_Ttdivision($this->database, $this->config);
		$division->read();
		$this->view
			->setMeta(array(		
				'title' => 'Tables and Results'
			))
			->setObject($division)
			->loadTemplate('tables-and-results');
	}


	public function fredHoldenCup() {
		$cup = new Model_Maincontent($this->database, $this->config);
		$media = new model_mainmedia($this->database, $this->config);
		$cup->readByType('cup');
		foreach ($cup->getData() as $minute) {
			if (! array_key_exists('media', $minute)) {
				continue;
			}
			$media->readById(array($minute['media']));
			$minute['media'] = $media->getData();
			$minuteCollection[] = $minute;
		}
		$cup->setData($minuteCollection);
		$this->view
			->setMeta(array(		
				'title' => 'Fred Holden Cup'
			))
			->setObject($cup)
			->loadTemplate('minutes');
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


	public function gallery() {
		$model = new Model_Maincontent($this->database, $this->config);
		$basePath = BASE_PATH . 'media/upload/gallery/';
		$albumTitle = '';
		foreach (new DirectoryIterator($basePath) as $order => $file) {
		    if ($file->isDir() && ! $file->isDot()) {
		    	$folderTitle = '';
		    	foreach (explode('-', $file->getFilename()) as $word) {
		    		$folderTitle .= ucfirst($word) . ' ';
		    	}
		        $folders[$order]['title'] = trim($folderTitle);
		        $folders[$order]['guid'] = $model->getGuid('media', 'gallery/' . urlencode($file->getFilename()) . '/');
		    }
		}
		if ($this->config->getUrl(1)) {
			$basePath .= $this->config->getUrl(1) . '/';
			foreach (explode('-', $this->config->getUrl(1)) as $word) {
				$albumTitle .= ucfirst($word) . ' ';
			}
			$this->view->setObject('album_title', trim($albumTitle));
		}
		foreach (glob($basePath . '*', GLOB_MARK) as $key => $handle) {
			if (! is_dir($handle)) {
				$fileInfo = pathinfo($handle);
				$files[$key] = $fileInfo;
				$files[$key]['timthumb'] = $model->getGuid('timthumb', 'media/upload/gallery/' . ($this->config->getUrl(1) ? $this->config->getUrl(1) . '/' : '') . $fileInfo['basename'] . '&w=250&h=200');
				$files[$key]['guid'] = $model->getGuid('media', 'media/upload/gallery/' . ($this->config->getUrl(1) ? $this->config->getUrl(1) . '/' : '') . urlencode($fileInfo['basename']));
			}
		}
		$this->view
			->setObject('folder', $folders)
			->setObject('file', $files)
			->loadTemplate('gallery');
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


	public function fixture() {
		$fixture = new Model_Ttfixture($this->database, $this->config);
		if ($this->config->getUrl(1)) {
			$id = $this->getId($this->config->getUrl(1));
			if (! $fixture->readSingleResult($id)) {
				$this->route('base');
			}
			$fixtureInfo = current($fixture->data);
			$this->view
				->setMeta(array(		
					'title' => 'East Lancashire Table Tennis League fixture'
				))
				->setObject($fixture)
				->setObject('fixture_info', $fixtureInfo)
				->loadTemplate('fixture-single');
		}
		$this->route('base');
	}


}
