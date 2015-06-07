<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

use OriginalAppName\Response;
use OriginalAppName\Site\Elttl\Model;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Year extends \OriginalAppName\Controller\Admin
{


	public function all() {
		$modelYear = new Model\Tennis\Year;
		$modelYear->read();

		// render
		$this
			->view
			->setDataKey('years', $modelYear->getData());
		return new Response($this->view->getTemplate('admin/tennis/year/all'));
	}
}
