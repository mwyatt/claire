<?php

/**
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Front_Press extends Controller
{


	public function index() {
		$press = new Model_Maincontent($this->database, $this->config);

echo '<pre>';
print_r($press);
echo '</pre>';
exit;


		if ($this->config->getUrl(1)) {
			if (! $press->readById($this->getId($this->config->getUrl(1)))) {
				$this->route('base', 'press/');
			}
			$this->view
				->setMeta(array(		
					'title' => $press->get('title')
					, 'keywords' => $press->get('meta_keywords')
					, 'description' => $press->get('meta_description')
				))
				->setObject($press)
				->loadTemplate('press-single');
		}
		$press->readByType('press');
		$this->view
			->setMeta(array(		
				'title' => 'All press'
				, 'keywords' => 'press, reports'
				, 'description' => 'All press currently published'
			))
			->setObject($press)
			->loadTemplate('press');
	}

	
}
