<?php

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Ajax_Image extends Controller_Ajax
{


	public function run()
	{
		$this->createThumbs();
	}


	/**
	 * generates the slug of all content items, this will be done
	 * automatically when creating one in the admin
	 */
	public function createThumbs()
	{
		$folder = glob(BASE_PATH . 'media' . DS . 'upload' . DS . '*');
		foreach ($folder as $filePath) {
			$image = new Image($filePath);  
			$fileInfo = pathinfo($filePath);
			$image->resize(640, 480, 'crop'); 
			$savePath = str_replace('upload\\', SITE . DS . 'thumb' . DS, $filePath);
			$image->save($savePath, 80);
		}
		exit('done something');
	}
}
