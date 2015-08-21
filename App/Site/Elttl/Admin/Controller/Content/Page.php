<?php

namespace OriginalAppName\Admin\Controller\Content;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Page extends \OriginalAppName\Admin\Controller\Content
{


	public function __construct()
	{
		parent::__construct();
		$this->type = 'page';
	}
}
