<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class File extends \OriginalAppName\Entity
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
	protected $name;


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
	 * get mime type based on extension
	 * @return string 
	 */
	public function getMimeType()
	{
		$extension = $this->getExtension();
		return isset($this->types[$extension]) ? $this->types[$extension] : false;
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
	public function getName() {
	    return $this->name;
	}
	
	
	/**
	 * @param string $Name 
	 */
	public function setName($name) {
	    $this->name = $name;
	    return $this;
	}
}
