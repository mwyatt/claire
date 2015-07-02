<?php

namespace OriginalAppName\Admin\Controller\Ajax;

use OriginalAppName;
use OriginalAppName\Helper as CoreHelper;
use OriginalAppName\Admin\Service;
use OriginalAppName\Session;
use OriginalAppName\Model;
use OriginalAppName\Response;
use \Exception;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Helper extends \OriginalAppName\Admin\Controller\Ajax
{


	/**
	 * takes a normal title and returns a slug
	 * @todo  need to fix uniqueness as could have duplicates
	 * @return string 
	 */
	public function slugify() {
		if (! isset($_REQUEST['title'])) {
			throw new Exception;
		}
		$friendlyTitle = CoreHelper::slugify($_REQUEST['title']);
		$ouput = $friendlyTitle;

		// output
		return new Response(json_encode($friendlyTitle));
	}
}
