<?php

/**
 * Various public functions
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class View extends Config {

	public $feedback;
	
	public function __construct($urlBase, $url) {
		$this->urlBase = $urlBase;
		$this->url = $url;
	}	
	
	
	public function urlMedia($ext = null) { 
		$base = $this->getUrlBase().'media/';
		return ($ext == null ? $base : $base.$ext);
	}
	
	
	// Convert String to a URL Friendly Version
	public function urlFriendly($value = null)
	{
	
		// everything to lower and no spaces begin or end
		$value = strtolower(trim($value));
		
		// adding - for spaces and union characters
		$find = array(' ', '&', '\r\n', '\n', '+',',');
		$value = str_replace ($find, '-', $value);
		
		//delete and replace rest of special chars
		$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$value = preg_replace ($find, $repl, $value);
		
		//return the friendly str
		return $value; 		
	}
	 
	 
	public function feedback() {

		if (array_key_exists('feedback', $_SESSION)) {
			$this->feedback = $_SESSION['feedback'];
			$_SESSION['feedback'] = false;
			return $feedback;
		} else {
			return false;
		}
	}
	

	public function latestTweet($user) {

		// XML
		$xml = simplexml_load_file("http://twitter.com/statuses/user_timeline/$user.xml?count=1");
		echo $xml->status->text[0];
	}


	/**
		@desc output install path
		@param $ext allows you to extend the base url for absolute urls
	*/
	public function urlCurrent($ext = null) { 
		$url = $this->getUrl();
		$base = $this->getUrlBase();
		$url = implode('/', $url).'/';
		return ($ext == null ? $base.$url : $base.$url.$ext);
	}


	public function urlHome($ext = null) { 
		return ($ext == null ? $this->getUrlBase() : $this->getUrlBase().$ext);
	}


	public function ccMediaUrl($ext = null) { 
		$base = $this->getUrlBase().'cc/view/assets/';
		return ($ext == null ? $base : $base.$ext);
	}


	public function urlTag($ext = null) { 
		$base = $this->getUrlBase().$this->getUrl(1).'/tags/';
		return ($ext == null ? $base : $base.$ext);
	}


	// Echo Logo
	public function logoMvc() {

		// logic here to add or remove a class and title="Open Homepage"
		
		$html =   '<a href="'.$this->urlHome().'">'
				. '<img src="'.$this->urlMedia('i/logo.png').'">'
				. '</a>';
		echo $html;
	}


	// Returns body class
	public function bodyClass() { 
		$val = ($this->getUrl(1) ? $this->getUrl(1) : 'home');
		return ' class="'.$val.'"';
	}
	
} 