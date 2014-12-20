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


	public $url;


	public function __construct()
	{
		$this->setView(new View);
		$this->setUrl();
	}


	public function setUrl()
	{
		$registry = \OriginalAppName\Registry::getInstance();
		$this->url = $registry->get('urlGenerator');
		return $this;
	}


	/**
	 * @return object 
	 */
	public function getUrl() {
	    return $this->url;
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
		$generator = $this->getUrl();
		$url = $generator->generate($label, $attributes, true);
		header('location:' . $url);

		// prevent continuation
		exit;
	}


	public function routeAbsolute($url)
	{
		header('location:' . $url);

		// prevent continuation
		exit;
	}
}
