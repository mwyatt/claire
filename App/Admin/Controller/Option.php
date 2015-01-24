<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Entity;
use OriginalAppName\Model;
use OriginalAppName\Session;
use OriginalAppName\Admin\Session as AdminSession;
use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Option extends \OriginalAppName\Controller\Admin
{


	/**
	 * @return object Response
	 */
	public function adminOptionAll($request) {
		
		// get options
		$options = $this->view->getData('option');

		// render
		$this
			->view
			->setDataKey('options', $options);
		return new Response($this->view->getTemplate('admin/option/all'));
	}
}
