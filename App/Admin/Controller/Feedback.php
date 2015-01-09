<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Feedback extends \OriginalAppName\Controller\Options
{


	public function __construct()
	{
		parent::__construct();

		// store feedback
		$sessionFeedback = new Session\Feedback;

		// users love feedback, all the time! so give it to 
		// them every page load!
		$this
			->view
			->setDataKey('feedback', $sessionFeedback->pull());
	}
}
