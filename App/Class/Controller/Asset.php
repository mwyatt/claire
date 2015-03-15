<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Response;

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
	 * starting point to handle the asset
	 * @param  array $request 
	 * @return object          response
	 */
	public function single($path)
	{

		// get request path
		$pathRequest = '';
		if (isset($path)) {
			$pathRequest = $path;
		}

		// entity
		$file = new Entity\File;
		$file->setPath($this->getFilePath($pathRequest));
		$this->setFile($file);

		// exception if no path found for this file
		if (! $file->getPath()) {
			return new Response('', 404);
		}

		// validate has extension
		$pathInfo = pathinfo($file->getPath());
		if (! isset($pathInfo['extension'])) {
			return new Response('', 404);
		}

		// return success
		return new Response($this->render());
	}
	

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
		$pathSite = SITE_PATH . 'asset' . DS . $pathRequest;
		$pathDefault = BASE_PATH . 'asset' . DS . $pathRequest;
		if (file_exists($pathSite)) {
			$path = $pathSite;
		} elseif (file_exists($pathDefault)) {
			$path = $pathDefault;
		}
	    return $path;
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
