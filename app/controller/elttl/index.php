<?php


/**
 * Controller
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Index extends Controller
{


	public function initialise()
	{

		// menu primary
		$json = new Json();
		$json->read('menu-primary');
		$menuPrimary = $json->getData();

		// cover
		$json = new Json();
		$json->read('home-cover');
		$covers = $json->getData();

		// menu Secondary
		$json = new Json();
		$json->read('menu-secondary');
		$menuSecondary = $json->getData();

		// menu Tertiary
		$json = new Json();
		$json->read('menu-tertiary');
		$menuTertiary = $json->getData();

		// ads
		$json = new Json();
		$json->read('ads');
		$ads = $json->getData();

		// divisions
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read();

		// template defaults
		$this->view
			->setObject('year', 0)
			->setObject('covers', $covers)
			->setObject('divisions', $modelTennisDivision->getData())
			->setObject('ads', $ads)
			->setObject('menuPrimary', $menuPrimary)
			->setObject('menuSecondary', $menuSecondary)
			->setObject('menuTertiary', $menuTertiary);
	}


	public function run()
	{
		if ($this->getComingSoon()) {
			return $this->soon();
		}
		if ($this->url->getPathPart(1)) {
			$this->route('base');
		}
		if (array_key_exists('query', $_GET)) {
			return $this->search();
		}
		return $this->home();
	}


	public function home() {

		// latest 3 posts
		$modelContent = new model_content($this);
		$modelContent
			->read(array(
				'where' => array(
					'type' => 'press',
					'status' => 'visible'
				),
				'limit' => array(0, 3),
				'order_by' => 'time_published desc'
			))
			->bindMeta('media')
			->bindMeta('tag')
			->bindUser();

		// gallery
		$this->setGallery();

		// template
		$this->view
			->setObject('contents', $modelContent->getData())
			->getTemplate('home');
	}


	public function soon() {
		$this->view->getTemplate('coming-soon');
	}


	public function setGallery()
	{
		$folder = glob(BASE_PATH . 'media' . DS . SITE . DS . 'thumb' . DS . '*');
		$files = array();
		foreach ($folder as $filePath) {
			$filePath = str_replace(BASE_PATH, '', $filePath);
			$files[] = str_replace(DS, US, $filePath);
		}
		
		// template
		$this->view
			->setObject('galleryPaths', $files);
	}
}
