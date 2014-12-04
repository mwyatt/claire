<?php

namespace OriginalAppName;


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
		$registry = \OriginalAppName\Registry::getInstance();
		$this->setUrl($registry->get('url'));
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
		$this->setMeta();

		// obtain path
		$path = $this->getTemplatePath($templatePath);
		if (! $path) {
			return;
		}

		// push stored into method scope
		extract($this->getData());

		// debugging
		if ($this->isDebug($this)) {
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
	 * gets template from site specific
	 * falls back to path from main template dir
	 * files must exist
	 * @return string 
	 */
	public function getTemplatePath($append) {
		$end = 'template' . DS . $append . EXT;
		$path = SITE_PATH . $end;
		if (file_exists($path)) {
			return $path;
		}
		$path = APP_PATH . $end;
		if (file_exists($path)) {
			return $path;
		}
		return $path . ' - template not found';
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
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public function getUrlAsset($url)
	{
		return $this->url->getCache('base') . $url . $this->getAssetVersion();
	}


	public function getAssetVersion()
	{
		return '?v=' . ASSET_VERSION;
	}


	/**
	 * grabs base path for the view folder, used for headers, footers
	 * and all includes within the view templates
	 * @return string 
	 */
	public function getPathMedia($append) {
		return BASE_PATH . 'media' . US . SITE . US . $append;
	}


	public function getUrlJs($append) {
		return $this->url->getCache('base') . 'js' . US . SITE . US . $append . $this->getAssetVersion();
	}


	/**
	 * appends admin to the path
	 * @param  string $template 
	 * @return string           
	 */
	public function pathAdminView($template = '') { 
		return $this->getTemplatePath('admin/' . $template);
	}	
	

	/**
	 * flexible url return, defualts to the base url of the website
	 * @param  string $key 
	 * @return string      
	 */
	public function getUrl($key = 'base') {
		return $this->url->getCache($key);
	}


	public function buildArchiveUrl($parts)
	{
		$urlCurrent = $this->getUrl('current');
		if (! strpos($urlCurrent, 'archive')) {
			return $this->url->build($parts);
		}
		array_unshift($parts, $this->url->getPathPart(1));
		array_unshift($parts, 'archive');
		return $this->url->build($parts);
	}
	

	public function getUrlMedia($append = '') {
		$registry = \OriginalAppName\Registry::getInstance();
		$generator = $registry->get('urlGenerator');
		return $generator->generate('assetSingle', ['path' => $append], true);
	}
	

	/**
	 * gets a users latest tweet!
	 * @param  string $user username
	 * @return string       the tweet
	 */
	public function latestTweet($user) {
		$xml = simplexml_load_file("http://twitter.com/statuses/user_timeline/$user.xml?count=1");
		echo $xml->status->text[0];
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
			$data['metaTitle'] = $data['option']['meta_title']->getValue();
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
	 * @param  array  $items 
	 * @param  string $label 
	 * @return string        
	 */
	public function appendS($items)
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


	/**
	 * inserts a key -> value pair into the data array
	 * does this need to be in the data class?
	 * @param  string $key   
	 * @param  any $value 
	 * @return object        
	 */
	public function insertData($key, $value)
	{
		$data = $this->getData();
		$data[$key] = $value;
		$this->setData($data);
		return $this;
	}
} 
