<?php

namespace OriginalAppName\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Asset extends \OriginalAppName\Controller
{


	protected $file;


	/**
	 * @return object Entity\File
	 */
	public function getFile() {
	    return $this->file;
	}
	
	
	/**
	 * @param object $file Entity\File
	 */
	public function setFile($file) {
	    $this->file = $file;
	    return $this;
	}


	/**
	 * get the file path of the asset
	 * could be site specific
	 * falls back to app
	 * @return string 
	 */
	public function getFilePath($pathRequest) {
		$path = '';
		$pathSite = APP_PATH . 'Site' . DS . SITE . DS . 'asset' . DS . $pathRequest;
		$pathDefault = BASE_PATH . 'asset' . DS . $pathRequest;
		if (file_exists($pathSite)) {
			$path = $pathSite;
		} elseif (file_exists($pathDefault)) {
			$path = $pathDefault;
		}
	    return $path;
	}



	/**
	 * starting point to handle the asset
	 * @param  array $request 
	 * @return object          response
	 */
	public function assetSingle($request)
	{

		// get request path
		$pathRequest = '';
		if (isset($request['path'])) {
			$pathRequest = $request['path'];
		}

		// entity
		$file = new Entity\File;
		$file->setPath($this->getFilePath($pathRequest));
		$this->setFile($file);

		// exception if no path found for this file
		if (! $file->getPath()) {
			throw new ResourceNotFoundException();
		}
		return new Response($this->render());
	}


	public function render()
	{
		$file = $this->getFile();
		$pathInfo = pathinfo($file->getPath());
		$file
			->setBaseName($pathInfo['basename'])
			->setName($pathInfo['filename'])
			->setExtension($pathInfo['extension']);
		$this->setFile($file);

		// start output buffer
		// return file output
		// improved speed as file_get_contents too slow
		$this->setHeaders();
		ob_start();
		readfile($file->getPath());
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}


	/**
	 * to render the file correctly in the browser
	 */
	public function setHeaders()
	{
		$file = $this->getFile();
		header('Content-Type:' . $file->getMimeType());
		header('Content-Length:' . filesize($file->getPath()));
		header('Content-Disposition: filename="' . $file->getBaseName() . '.jpg"');
	}
}
