<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Session;
use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Admin extends \OriginalAppName\Controller
{


	public function __construct()
	{
		Parent::__construct();
		$this->defaultGlobalAdmin();
	}


	/**
	 * store default data in view
	 * store default site date in view
	 * @return null 
	 */
	public function defaultGlobalAdmin()
	{
		$sessionUser = new Session\Admin\User;
		$sessionFeedback = new Session\Feedback;

		// not logged in
		if (! $sessionUser->isLogged()) {
			$this->route('admin');
		}
		
		// logout
		if (array_key_exists('logout', $_REQUEST) && $sessionUser->isLogged()) {
			$sessionUser->delete();
			$sessionFeedback->set('successfully logged out');
			$this->route('admin');
		}

		// more resource
		$this->readMenu();
		$this->readUser();
	}


	public function readUser()
	{
		$sessionUser = new Session\Admin\User;
		$modelUser = new model_user();
		$modelUser->readId([$sessionUser->get('id')])
		if (! $entityUser = current($modelUser->getData())) {
			$sessionUser->delete();
			$this->route('admin');
		}
		$this
			->view
			->mergeData(['user', $entityUser]);
	}


	public function readMenu()
	{
		$json = new \OriginalAppName\Json;
		$json->read('admin/menu');
		$this
			->view
			->mergeData(['menu', $json->getData()]);
	}
}
