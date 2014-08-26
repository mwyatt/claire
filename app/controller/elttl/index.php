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

		// divisions
		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read();
		
		// template
		$this->view
			->setObject('covers', $covers)
			->setObject('divisions', $modelTennisDivision->getData())
			->setObject('menuPrimary', $menuPrimary)
			->setObject('menuSecondary', $json->getData());
	}


	public function run()
	{
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
		$modelContent->read(array(
			'where' => array(
				'type' => 'press',
				'status' => 'visible'
			),
			'limit' => array(0, 6),
			'order_by' => 'time_published desc'
		));
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
		$modelContent->bindUser();
		$this->view->setObject('contents', $modelContent->getData());
		$this->view->getTemplate('home');
	}
}
