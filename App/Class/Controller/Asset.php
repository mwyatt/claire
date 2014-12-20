<?php

namespace OriginalAppName\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Asset extends \OriginalAppName\Controller
{


	public function getPathDefault($append = '')
	{
		return BASE_PATH . 'asset' . DS . $append;
	}


	public function getPathSite($append = '')
	{
		return BASE_PATH . 'app' . DS . 'site' . DS . SITE . DS . 'asset' . DS . $append;
	}


	/**
	 * starting point to handle the asset
	 * @param  array $request 
	 * @return object          response
	 */
	public function assetSingle($request)
	{

		// logic
		// if asset not found
		// 

		$pathRequest = '';
		if (isset($request['path'])) {
			$pathRequest = $request['path'];
		}
		$pathSite = $this->getPathSite($pathRequest);
		$pathDefault = $this->getPathDefault($pathRequest);
		if (file_exists($pathSite)) {
			$this->setPath($pathSite);
		} elseif (file_exists($pathDefault)) {
			$this->setPath($pathDefault);
		}
		if (! $this->getPath()) {
			throw new ResourceNotFoundException();
		}
		return new Response($this->render());
	}


	public function render()
	{
		$path = $this->getPath();
		$pathInfo = pathinfo($path);
		$this->setBaseName($pathInfo['basename']);
		$this->setFileName($pathInfo['filename']);
		$this->setExtension($pathInfo['extension']);
		$this->setHeaders();

		// start output buffer
		// return file output
		// improved speed as file_get_contents too slow
		ob_start();
		readfile($path);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}


	public function setHeaders()
	{
		header('Content-Type:' . $this->getMimeType());
		header('Content-Length:' . filesize($this->getPath()));
		header('Content-Disposition: filename="' . $this->getBaseName() . '.jpg"');
	}
}
