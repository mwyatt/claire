<?php

namespace OriginalAppName;


/**
 * example url split by sesctions
 * {http://}{store}.{example}.{com}/{topics/subtopic/}{descriptive-product-name}{#top}
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Url
{


	/**
	 * {http://}
	 * @var string
	 */
	private $protocol;


	private $subdomain;


	private $domain;


	private $topLevelDomain;

	

	private $anchor;


	/**
	 * foo.co.uk/
	 * @var string
	 */
	private $host;


	/**
	 * foo, bar
	 * @var array
	 */
	private $path;


	/**
	 * ?foo=bar
	 * @var string
	 */
	private $query;


	/**
	 * #foo
	 * @var string
	 */
	private $hash;


	/**
	 * filled with handy urls which are required in many places
	 * @var array
	 */
	private $cache;


	/**
	 * segmented path for controller use
	 * @var array
	 */
	private $parsed;


	/**
	 * remember, you dont need all the url constructs, right away
	 * just build the base url, without https / http
	 */
	public function __construct() {

		// server validation
		$keys = array('HTTP_HOST', 'SCRIPT_NAME', 'HTTP_HOST', 'REQUEST_URI', 'SERVER_PORT');
		if (! Helper::arrayKeyExists($keys, $_SERVER)) {
			exit('a required server key is missing to build the url');
		}
		$this->setParsed();
		$keys = array('scheme', 'host', 'path');
		if (! Helper::arrayKeyExists($keys, $this->getParsed())) {
			exit('a key is missing from the parse_url array');
		}
		$this->setHost();
		$this->setPath();
		$this->setQuery();
		$this->setProtocol();
		$this->setCache();
	}


	/**
	 * @return string 
	 */
	public function getHost()
	{
		return $this->host;
	}


	/**
	 * probes the host portion of url for localhost
	 * if found returns true
	 * @return boolean 
	 */
	public function isLocal()
	{
		if (strpos($this->getHost(), 'localhost') === false) {
			return;
		}
		return true;
	}


	/**
	 * @return string 
	 */
	public function getQuery()
	{
		return $this->query;
	}


	/**
	 * builds a handy cached array for quick access to the common url patterns
	 * this could possibly be done more dynamically..
	 * @todo solve http(s) issue, how to define when and how you want it?
	 */
	public function setCache()
	{
		$protocol = $this->getProtocol();
		$host = $this->getHost();
		$query = '?' . $this->getQuery();
		$path = implode(US, $this->getPath()) . US;
		$this->cache = array(
			'base' => $protocol . $host,
			'admin' => $protocol . $host . 'admin' . US,
			'media' => $protocol . $host . 'media' . US . SITE . US,
			'current' => $protocol . $host . $path . $query,
			'current_sans_query' => $protocol . $host . $path
		);
	}


	/**
	 * @param  string $key 
	 * @return string       
	 */
	public function getCache($key = false)
	{
		if (! array_key_exists($key, $this->cache)) {
			return;
		}
		return $this->cache[$key];
	}


	/**
	 * determine the base url by parsing the current url and taking only whats
	 * needed
	 * @todo i get the feeling this could be simplified
	 */
	public function setHost()
	{

		// get request and script
		$host = strtolower($_SERVER['HTTP_HOST']);
		$script = strtolower($_SERVER['SCRIPT_NAME']);
		$script = str_replace('index.php', '', $script);

		// remove any empty segments
		$script = explode(US, $script);
		$script = array_filter($script); 
		$script = array_values($script);

		// server side for some reason adding trailing slash
		// this adds double and then strips out
		$host = $host . US . implode(US, $script) . US;
		if (strpos($host, '//')) {
			$host = str_replace('//', '/', $host);
		}

		// hostname/script/ <- install directory
		$this->host = $host;
		return $this;
	}
	

	/**
	 * http(s)://
	 * @return string 
	 */
	public function getProtocol($secure = false)
	{
		$protocol = 'http';
		if ($secure || $this->isSecure()) {
			$protocol .= 's';
		}
		return  $protocol . ':' . US . US;
	}


	/**
	 * @return array 
	 */
	public function getParsed()
	{
		return $this->parsed;
	}


	/**
	 * builds array based upon parse_url
	 */
	public function setParsed()
	{
		$host = strtolower($_SERVER['HTTP_HOST']);
		$request = strtolower($_SERVER['REQUEST_URI']);
		$urlParsed = parse_url($this->getProtocol() . $host . $request);
		$this->parsed = $urlParsed;
	}


	/**
	 * builds array of current path for use in controllers
	 */
	public function setPath()
	{

		// get host and path
		// to intersect against eachother
		$parsed = $this->getParsed();
		$host = $this->getHost();	
		$pathParts = explode(US, $parsed['path']);
		$hostParts = explode(US, $host);
		$parts = array();

		// strip out install directory and empty keys
		// build parts array
		foreach ($pathParts as $pathPart) {
			if (in_array($pathPart, $hostParts)) {
				continue;
			}
			$parts[] = $pathPart;
		}
		$this->path = $parts;
	}


	/**
	 * set the query based on parsed finds
	 */
	public function setQuery()
	{
		$parsed = $this->getParsed();
		if (! array_key_exists('query', $parsed)) {
			return;
		}
		$this->query = $parsed['query'];
	}


	/**
	 * sets the scheme
	 * @todo make more dynamic?
	 */
	public function setProtocol()
	{
		$parsed = $this->getParsed();
		$this->scheme = $parsed['scheme'] . ':' . US . US;
	}


	/**
	 * @return array 
	 */
	public function getPath() {
		return $this->path;
	}


	public function getPathString()
	{
		$path = implode(US, $this->path) . US;
		$path = str_replace('//', '/', $path);
		return $path;
	}


	/**
	 * returns path single segment
	 * @param  int $key 0/1/2/3/
	 * @return string
	 */
	public function getPathPart($key = false)
	{

		// invalid
		if (gettype($key) != 'integer') {
			return;
		}
		
		// cache
		$path = $this->path;

		// need specific key, key references the position
		if (! array_key_exists($key, $path)) {
			return;
		}
		return $path[$key];
	}


	/**
	 * checks to see if the current connection is secure
	 * checks server vars and server port, untested
	 * @return boolean 
	 */
	public function isSecure() {
		return (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
	}


	/**
	 * upgraded get url method, allows unlimited segments
	 * friendly helps out with slashes and making things safe
	 * @param  array   $segments      each/segment/
	 * @return string                 the url
	 */
	public function build($segments = array(), $friendly = true) {
		$finalUrl = $this->getCache('base');
		foreach ($segments as $segment) {
			if ($friendly) {
				$segment = Helper::urlFriendly($segment);
			}
			$finalUrl .= $segment . ($friendly ? '/' : '');
		}
		return $finalUrl;
	}


	public function getHash()
	{
		return '';
	}


	public function getRequest()
	{
		return $this->getPathString() . $this->getHash() . $this->getQuery();
	}
}
