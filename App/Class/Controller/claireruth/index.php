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

		// main nav
		$json = new Json();
		$json->read('main-menu');
		$this->view->setDataKey('mainMenu', $json->getData());
	}


	public function run()
	{
		if ($this->url->getPathPart(1)) {
			$this->redirect('base');
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
				'type' => 'post',
				'status' => 'visible'
			),
			'limit' => array(0, 6),
			'order_by' => 'time_published desc'
		));
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
		$modelContent->bindUser();
		$this->view->setDataKey('contents', $modelContent->getData());
		$this->view->getTemplate('home');
	}


	public function sitemapxml() {
		header('Content-Type: application/xml');
		$content = new model_content($this);
		$player = new model_ttplayer($this);
		$team = new model_ttteam($this);
		$fixture = new model_ttfixture($this);
		$division = new model_ttdivision($this);
		$this->view
			->setDataKey('model_ttfixture', $fixture->readFilled()->getData())
			->setDataKey('model_ttdivision', $division->read()->getData())
			->setDataKey('model_ttteam', $team->read()->getData())
			->setDataKey('model_ttplayer', $player->read()->getData())
			->setDataKey('model_content_cup', $content->readByType('cup')->getData())
			->setDataKey('model_content_minutes', $content->readByType('minutes')->getData())
			->setDataKey('model_content_page', $content->readByType('page')->getData())
			->setDataKey('model_content_press', $content->readByType('press')->getData())
			->loadJustTemplate('sitemap');
	}
}
