<?php

namespace OriginalAppName;

use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller
 *
 * PHP version 5
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller
{


	public $view;


	public function __construct($request)
	{
		$this->setView(new View);
		$this->default();
		if (isset($request['_route'])) {
			if (method_exists($this, $request['_route'])) {
				return $this->$request['_route']($request);
			} else {
				exit('chosen controller method \'' . $request['_route'] . '\' not found');
			}
		}
	    return $this->notFound($request);
	}


	/**
	 * store default data in view
	 * @return null 
	 */
	public function default()
	{

		// site defaults
		if (method_exists($this, 'siteDefault')) {
			$this
				->view
				->mergeData($this->siteDefault());
		}

		// default options
		$serviceOptions = new Service\Options();
		$this
			->view
			->mergeData(['options' => $serviceOptions->read()]);
	}


	public function notFound($request)
	{
		// template
		$view = new View([
			'metaTitle' => 'Not found'
		]);
		return new Response($view->getTemplate('not-found'), Response::HTTP_NOT_FOUND);
	}


	/**
	 * @return object 
	 */
	public function getView() {
	    return $this->view;
	}
	
	
	/**
	 * @param object $view 
	 */
	public function setView($view) {
	    $this->view = $view;
	    return $this;
	}
}
