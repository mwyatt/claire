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
	 * needs to be loaded for all controllers
	 * front, admin and ajax or any others
	 * @return null 
	 */
	public function defaultGlobal()
	{
		$serviceOptions = new Service\Options();
		$this
			->view
			->setDataKey('option', $serviceOptions->read());
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


	/**
	 * redirects the user to another url and terminates
	 * utilising the generator from symfony
	 * @param  string $label      routeKey
	 * @param  array $attributes if required
	 * @return null             
	 */
	public function route($label, $attributes = [])
	{
		$registry = \OriginalAppName\Registry::getInstance();
		$generator = $registry->get('urlGenerator');
		$url = $generator->generate($label, $attributes, true);
		header('location:' . $url);

		// prevent continuation
		exit;
	}
}
