<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class View extends \OriginalAppName\Data
{


	/**
	 * page meta information
	 * @var array
	 */
	public $meta = array();
	

	/**
	 * stores output html, can be combined when loading multiple templates
	 * starts as a empty string so that it can be built upon '.='
	 * @var string
	 */
	public $data = '';


	public $url;


	/**
	 * needed for meta defaults
	 * @param array $system 
	 */
	public function __construct($data) {
		$registry = \OriginalAppName\Registry::getInstance();
		$this->setUrl($registry->get('url'));
		$this->setMetaDefaults($data);
		$this->setData(array_merge($this->getDataDefault(), $data));
	}


	/**
	 * @param object $url 
	 */
	public function setUrl($url) {
	    $this->url = $url;
	    return $this;
	}


	public function getDataDefault()
	{
		$controller = new \OriginalAppName\Controller();
		return $controller->index();
	}


	// /**
	//  * sets header and outputs the data
	//  * only used by the controller class
	//  */
	// public function render()
	// {

	// 	// default header
	// 	header('Content-type: text/html; charset=utf-8'); 

	// 	// output
	// 	echo $this->getData();
	// }

	
	/**
	 * load template file and prepare all objects for output
	 * @param  string $templatePath 
	 */
	public function getTemplate($templatePath) {

		// obtain path
		$path = $this->getTemplatePath($templatePath);
		if (! $path) {
			return;
		}

		// push stored into method scope
		extract($this->getData());
echo '<pre>';
print_r($this->getData());
echo '</pre>';
exit;

		// debugging
		if ($this->isDebug($this)) {
			echo '<pre>';
			print_r($this->getData());
			echo '</pre>';
			echo '<hr>';
			exit;
		}

		// start output buffer
		ob_start();

		// render template using extracted variables
		include($path);
		$content = ob_get_contents();

		// destroy output buffer
		ob_end_clean();

		// add this data to existing
		$this->setData($content);

		// return just loaded template result
		return $content;
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
		return $this->url->getCache('media') . $append;
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
	 * if any meta has been missed, merge with the defaults
	 */
	public function setMetaDefaults()
	{
/*
array(
			'title' => $this->config->getOption('meta_title'),
			'keywords' => $this->config->getOption('meta_keywords'),
			'description' => $this->config->getOption('meta_description')
		)
 */

		$this->setMeta([]);
		return $this;
	}
	

	/**
	 * sets the meta for a common page
	 * title
	 * description
	 * keywords
	 * @param array $metas 
	 */
	public function setMeta($metas) {		

		// resource for appending
		$append = '';

		// site title which can be added on to make the page title
		// more interesting
		$siteTitle = 'meta title';/*$this->config->getOption('meta_title')*/

		// pass through and set the keys where required
		// keys are already set on construct
		foreach ($metas as $key => $meta) {

			// append title of site to the title if one is passed
			if ($key == 'title' && $meta != $siteTitle) {
				$append = ' | ' . $siteTitle;
			}
			$this->meta[$key] = $metas[$key] . $append;
		}
		return $this;
	}


	/**
	 * returns requested meta key
	 * @param  string $key meta key
	 * @return bool or string
	 */
	public function getMeta($key) {
		if (array_key_exists($key, $this->meta)) {
			return $this->meta[$key];
		}
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
} 
