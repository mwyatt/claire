<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Registry;
use OriginalAppName\Response;
use Intervention\Image\ImageManagerStatic;
use OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Asset extends \OriginalAppName\Controller
{


	protected $file;


	protected $thumbLabels = [
		'small' => [130, 130],
		'medium' => [300, 300],
		'large' => [640, 480]
	];


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

		// site specific
		if (file_exists($pathSite)) {
			$path = $pathSite;

		// default
		} elseif (file_exists($pathDefault)) {
			$path = $pathDefault;

		// ungenerated thumb
		} elseif ($this->isThumb($pathRequest)) {
			$this->generateThumb($pathRequest);
		}

		// return path or empty
	    return $path;
	}


	/**
	 * builds and saves the thumb
	 * redirects to the same url to then load the saved image
	 * @param  string $pathRequest 
	 * @return null              
	 */
	public function generateThumb($pathRequest)
	{
		$pathSansLabel = $this->getPathSansThumbLabel($pathRequest);
		$dimensions = $this->getThumbLabelDimensions($pathRequest);

		// open an image file
		$image = ImageManagerStatic::make(BASE_PATH . 'asset/' . $pathSansLabel)
			->fit(current($dimensions), end($dimensions))
			->sharpen(5)
			->brightness(5)
			->save(BASE_PATH . 'asset/' . $pathRequest, 75);

		// redirect to same url after creation
		// messy but is this the only redirect which will go to a asset?
		$registry = Registry::getInstance();
		$url = $registry->get('url');
		$url = $url->generate('asset/single', ['path' => $pathRequest]);
		$this->redirectAbsolute(rtrim($url, US));
	}


	/**
	 * test if the path is a thumbnail
	 * @param  string  $pathRequest 
	 * @return boolean              
	 */
	public function isThumb($pathRequest)
	{

		// valid format
		$pathInfo = pathInfo($pathRequest);
		$extension = $pathInfo['extension'];
		if (! in_array($extension, ['jpg', 'gif', 'png'])) {
			return;
		}

		// valid label
		foreach ($this->getThumbLabels() as $label => $dimensions) {
			if (strpos($pathRequest, $label)) {
				return true;
			}
		}
	}


	/**
	 * get path without thumb label
	 * @param  string $pathRequest 
	 * @return string              
	 */
	public function getPathSansThumbLabel($pathRequest)
	{
		foreach ($this->getThumbLabels() as $label => $dimensions) {
			if (strpos($pathRequest, $label)) {
				return str_replace('-' . $label, '', $pathRequest);
			}
		}
	}


	public function getThumbLabelDimensions($pathRequest)
	{
		foreach ($this->getThumbLabels() as $label => $dimensions) {
			if (strpos($pathRequest, $label)) {
				return $dimensions;
			}
		}
	}


	/**
	 * @return array 
	 */
	public function getThumbLabels() {
	    return $this->thumbLabels;
	}
	
	
	/**
	 * @param array $thumbLabels 
	 */
	public function setThumbLabels($thumbLabels) {
	    $this->thumbLabels = $thumbLabels;
	    return $this;
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
