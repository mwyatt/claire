<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Asset extends \OriginalAppName\Entity
{


	/**
	 * foo/bar/file-name.ext
	 * @var string
	 */
	protected $path;


	/**
	 * file-name.ext
	 * @var string
	 */
	protected $fileName;


	/**
	 * file-name
	 * @var string
	 */
	protected $baseName;


	/**
	 * .ext
	 * @var string
	 */
	protected $extension;


	/**
	 * mime type
	 * @var string
	 */
	protected $type;


	/**
	 * association of ext => mime
	 * @var array
	 */
	protected $types = [
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


	/**
	 * retreives mime based on ext
	 * @return string 
	 */
	public function getMimeType()
	{
		$extension = $this->getExtension();
		$types = $this->getTypes();
		if (isset($types[$extension])) {
			return $types[$extension];
		}
	}
}
