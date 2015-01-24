<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use OriginalAppName\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content extends \OriginalAppName\Admin\Controller\Ajax
{

	
	public function run()
	{
		$this->runMethod(3);
	}


	/**
	 * takes a normal title and returns a unique slug by looking at all other
	 * content 
	 * @return string 
	 */
	public function slug() {
		if (! array_key_exists('title', $_GET)) {
			exit;
		}
		$friendlyTitle = Helper::urlFriendly($_GET['title']);
		$modelcontent = new model_content($this);
		$modelcontent->read(array(
			'where' => array(
				'slug' => $friendlyTitle
			)
		));
		if ($modelcontent->getData()) {
			echo $friendlyTitle . '-2';
		} else {
			echo $friendlyTitle;
		}
	}
}
