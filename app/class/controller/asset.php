<?php

namespace OriginalAppName\Controller;

use OriginalAppName\View;
use OriginalAppName\Service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Asset extends \OriginalAppName\Controller
{


	public $path;


	public $fileName;


	public $baseName;


	public $extension;


	public $types = [
		'pdf' => 'application/pdf',
		'svg' => 'image/svg+xml',
		'css' => 'text/css',
		'txt' => 'text/plain',
		'gif' => 'image/gif',
		'png' => 'image/png',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'js' => 'application/javascript'
	];


	/**
	 * @return array 
	 */
	public function getTypes() {
	    return $this->types;
	}
	
	
	/**
	 * @param array $types 
	 */
	public function setTypes($types) {
	    $this->types = $types;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getExtension() {
	    return $this->extension;
	}
	
	
	/**
	 * @param string $extension 
	 */
	public function setExtension($extension) {
	    $this->extension = $extension;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getBaseName() {
	    return $this->baseName;
	}
	
	
	/**
	 * @param string $baseName 
	 */
	public function setBaseName($baseName) {
	    $this->baseName = $baseName;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getPath() {
	    return $this->path;
	}
	
	
	/**
	 * @param string $path 
	 */
	public function setPath($path) {
	    $this->path = $path;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getFileName() {
	    return $this->fileName;
	}
	
	
	/**
	 * @param string $fileName 
	 */
	public function setFileName($fileName) {
	    $this->fileName = $fileName;
	    return $this;
	}


	public function getPathDefault($append = '')
	{
		return BASE_PATH . 'asset' . DS . $append;
	}


	public function getPathSite($append = '')
	{
		return BASE_PATH . 'app' . DS . 'site' . DS . SITE . DS . 'asset' . DS . $append;
	}


	public function assetSingle($request)
	{
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
		return file_get_contents($path);
	}


	public function setHeaders()
	{
		header('Content-Type:' . $this->getMimeType());
		header('Content-Length:' . filesize($this->getPath()));
		header('Content-Disposition: filename="' . $this->getBaseName() . '.jpg"');
	}


	public function getMimeType()
	{
		$extension = $this->getExtension();
		$types = $this->getTypes();
		if (isset($types[$extension])) {
			return $types[$extension];
		}
	}
}
