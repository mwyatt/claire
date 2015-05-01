<?php

namespace OriginalAppName;

use OriginalAppName\Registry;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class View extends \OriginalAppName\Data
{


	public $url;


	/**
	 * needed for meta defaults
	 * @param array $system 
	 */
	public function __construct() {
		$registry = Registry::getInstance();
		$url = $registry->get('url');
		$this->setUrl($url);
	}


	/**
	 * @param object $url 
	 */
	public function setUrl($url) {
	    $this->url = $url;
	    return $this;
	}

	
	/**
	 * load template file and prepare all objects for output
	 * @param  string $templatePath 
	 */
	public function getTemplate($templatePath) {

		// common meta vars
		$this->setMeta();

		// obtain path
		$path = $this->getTemplatePath($templatePath);
		if (! $path) {
			return;
		}

		// push stored into method scope
		extract($this->getData());

		// debugging
		if (isset($_REQUEST['view'])) {
			echo '<pre>';
			print_r($this->getData());
			echo '</pre>';
			echo '<hr>';
			exit;
		}

		// start output buffer
		// @todo start this at the start of the app?
		ob_start();

		// render template using extracted variables
		include($path);
		$content = ob_get_contents();

		// destroy output buffer
		// @todo convert to ob_clean
		ob_end_clean();

		// add this data to existing
		$this->setData($content);

		// return just loaded template result
		return $content;
	}


	public function getTemplateMustache($templatePath)
	{
		
		// data
		$data = $this->getData();

		// boot engine
		$mustacheEngine = new Mustache_Engine([
		    'loader' => new Mustache_Loader_FilesystemLoader(BASE_PATH . 'newsletter' . DS . '24-11-2014' . DS . 'template')
			// 'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/partials'),
		]);
		return $mustacheEngine->render($templatePath, $data);

		$m = new Mustache_Engine(array(
			'loader'          => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views'),
			'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/partials'),
		));

	}


	/**
	 * finds a template, either using a prioroty or
	 * gracefully searching
	 * @param  string $append    foo/bar
	 * @return string            the path
	 */
	public function getTemplatePath($append) {

		// appending
		$end = 'template' . DS . $append . EXT;

		// site-specific
		$path = SITE_PATH . $end;
		if (file_exists($path)) {
			return $path;
		}
		
		// common
		$path = APP_PATH . $end;
		if (file_exists($path)) {
			return $path;
		}

		// problem
		exit('view::getTemplatePath - ' . $path);
	}


	/**
	 * find the asset path for a particular path
	 * used with includes
	 * @param  string $append foo/bar.svg
	 * @return string         
	 */
	public function getAssetPath($append) {
		$end = 'asset' . DS . $append;
		$path = SITE_PATH . $end;
		if (file_exists($path)) {
			return $path;
		}
		$path = BASE_PATH . $end;
		if (file_exists($path)) {
			return $path;
		}
		exit('view::getAssetPath - ' . $path);
	}


	/**
	 * grabs base path for the view folder, used for headers, footers
	 * and all includes within the view templates
	 * @return string 
	 */
	public function getPath($append) {
		$path = BASE_PATH;
		return $path . $append;
	}


	/**
	 * returns an absolute url of the asset complete with asset version
	 * @param  string $append path to asset
	 * @return string         url of asset with modified time
	 */
	public function getUrlAsset($append)
	{
		$path = $this->getAssetPath($append);

		// check actually there
		if (! file_exists($path)) {
			return;
		}

		// get mod time
		$modifiedTime = filemtime($path);

		// return url to asset with modified time as query var
		return $this->url->generate() . 'asset' . US . $append . '?' . $modifiedTime;
	}


	/**
	 * grabs base path for the view folder, used for headers, footers
	 * and all includes within the view templates
	 * @return string 
	 */
	public function getPathMedia($append) {
		return BASE_PATH . 'media' . US . SITE . US . $append;
	}


	/**
	 * appends admin to the path
	 * @param  string $template 
	 * @return string           
	 */
	public function pathAdminView($template = '') { 
		return $this->getTemplatePath('admin/' . $template);
	}	


	public function buildArchiveUrl($parts)
	{
		$urlCurrent = $this->url->generate('current');
		if (! strpos($urlCurrent, 'archive')) {
			return $this->url->build($parts);
		}
		array_unshift($parts, $this->url->getPathPart(1));
		array_unshift($parts, 'archive');
		return $this->url->build($parts);
	}
	

	/**
	 * returns a body class using the parts of the url after the domain
	 * @return string 
	 */
	public function getBodyClass() { 
		$bodyClass = '';
		foreach ($this->url->getPath() as $path) {
			$bodyClass .= $path . '-';
		}
		return $bodyClass = rtrim($bodyClass, -1);
	}


	/**
	 * modifies the data array to ensure the metas are filled with custom stuff
	 * or fall back to defaults
	 */
	public function setMeta() {		
		$data = $this->getData();

		// depends on option
		if (! isset($data['option'])) {
			return $this;
		}

		// title
		if (isset($data['metaTitle'])) {
			$data['metaTitle'] = $data['metaTitle'] . ' | ' . $data['option']['meta_title']->getValue();
		} else {
			if (isset($data['option']['meta_title'])) {
				$data['metaTitle'] = $data['option']['meta_title']->getValue();
			}
		}

		// description
		if (! isset($data['metaDescription'])) {
			$data['metaDescription'] = $data['option']['meta_description']->getValue();
		}

		// keywords
		if (! isset($data['metaKeywords'])) {
			$data['metaKeywords'] = $data['option']['meta_keywords']->getValue();
		}

		// commit data
		$this->setData($data);
		return $this;
	}


	/**
	 * looks at an array and creates a string e.g. '3 Items'
	 * is this view only? otherwise should be in helper
	 * @param  array  $items 
	 * @param  string $label 
	 * @return string        
	 */
	public function pluralise($items)
	{
		return count($items) > 1 ? 's' : '';
	}


	/**
	 * provides a bool response to whether the user is using a admin url
	 * @return boolean 
	 */
	public function isAdmin()
	{
		return $this->url->getPathPart(0) == 'admin';
	}


	/**
	 * prepends the base and key folder for the media upload dir
	 * @param  string $path 
	 * @return string       
	 */
	public function getPathMediaUpload($path) { 
		return $this->url->getCache('base') . 'media/upload/' . $path;
	}
} 
