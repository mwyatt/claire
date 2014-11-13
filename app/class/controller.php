<?php

namespace OriginalAppName;

use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller
{


	public $view;


	public function __construct()
	{
		$this->setView(new View);
		$this->defaultGlobal();
	}


	/**
	 * store default data in view
	 * store default site date in view
	 * @return null 
	 */
	public function defaultGlobal()
	{
		$serviceOptions = new Service\Options();
		$className = '\\OriginalAppName\\Site\\' . ucfirst(SITE) . '\\Service\\Common';
		$serviceCommon = new $className;
		$this
			->view
			->mergeData(['option' => $serviceOptions->read()])
			->mergeData($serviceCommon->read());
	}


	public function notFound($request)
	{
		// template
		$this
			->view
			->mergeData(['metaTitle' => 'Not found']);
		return new Response($this->view->getTemplate('not-found'), Response::HTTP_NOT_FOUND);
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
