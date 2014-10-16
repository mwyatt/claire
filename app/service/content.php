<?php

/**
 * responsible for various content types (projects, posts and pages)
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Service_Content extends Service
{
	

	/**
	 * example function, this is not really a good use of this
	 * @return [type] [description]
	 */
	public function readAll()
	{
		$modelContent = new model_content($this);
		$modelContent->read(array(
			'where' => array(
				'slug' => $this->url->getPathPart(1),
				'status' => 'visible',
				'type' => $this->url->getPathPart(0)
			)
		));
		
		if (! $modelContent->getData()) {
			$this->route('base');
		}
		$modelContent->bindMeta('media');
		$modelContent->bindMeta('tag');
	}
}
