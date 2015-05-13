<?php

namespace OriginalAppName\Site\Codex\Controller;

use OriginalAppName\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


	public function home() {
		$this
			->view
			->appendAsset('mustache', 'ok/google')
			->setDataKey('pathSite', SITE_PATH)
			->setDataKey('structure', include SITE_PATH . '_structure' . EXT);
		return new Response($this->view->getTemplate('_content'));
		// template
		// 	->setDataKey('projects', $entitiesProject);
		// return new Response($this->view->getTemplate('home'));
	}
}
