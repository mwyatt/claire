<?php

/**
 * Teleporting Data since 07.10.12
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class View extends Model
{

	public $template;
	public $session;
	public $meta = array();
	public $cache = array(
		'player' => true
	);
	
	
	/**
	 * prepare all core objects here and register
	 */	
	public function header() {
		$user = new Model_Mainuser($this->database, $this->config);
		$menu = new Model_Mainmenu($this->database, $this->config);
		$session = new Session($this->database, $this->config);
		$mainoption = new Model_Mainoption($this->database, $this->config);
		$menu->admin();
		$menu->adminSub();
		$mainoption->select();		
		$this->getFeedback();
		$this->setMeta(array(
			'title' => $mainoption->get('meta_title'),
			'keywords' => $mainoption->get('meta_keywords'),
			'description' => $mainoption->get('meta_description')
		));
		$this->setObject(array(
			$mainoption
			, $menu
			, $session
		));
	}

	
	/**
	 * load template file and prepare all objects for output
	 * @param  string $templateTitle 
	 * @return bool                
	 */
	public function loadTemplate($templateTitle)
	{			
		$cache = new Cache($this->database, $this->config)	;
		$path = BASE_PATH . 'app/view/' . strtolower($templateTitle) . '.php';
		
		if (!file_exists($path)) {
			return false;
		}

		$this->template = $path;
		
		
		// $this->config->url['history'] = $session->getPreviousUrl($this->config->url['current']);

		// prepare common models
		$this->header();
	
		// push objects to method scope
		$index = 0;
		foreach ($this->objects as $title => $object) {
			if ($object->getData()) {
				if (array_key_exists($title, $this->data)) {
					$this->data[$title . $index ++] = $object->getData();
				} else {
					$this->data[$title] = $object->getData();
				}
			} else {
				if (array_key_exists($title, $this->data)) {
					$this->data[$title . $index ++] = false;
				} else {
					$this->data[$title] = false;
				}
			}
		}

		// echo '<pre>';
		// print_r($this->data);
		// echo '</pre>';
		// exit;

		// presentation & cache
		ob_start();	
		require_once($path);
		$cache->create($templateTitle, ob_get_contents());
		ob_end_flush();	
		exit;
	}		
		


	/**
	 * master get function for interacting with $this->data
	 * @param  string|array  $one      
	 * @param  string $two   
	 * @param  string $three 
	 * @return array|string|int            
	 */
	public function get($one = null, $two = null, $three = null) {	
		if (is_array($one)) {
			if (array_key_exists($two, $one)) {
				return $one[$two];
			}
			return;
		}
		if (array_key_exists($one, $this->data)) {
			if (is_array($this->data[$one]) && array_key_exists($two, $this->data[$one])) {
				if (is_array($this->data[$one][$two]) && array_key_exists($three, $this->data[$one][$two])) {
					return $this->data[$one][$two][$three];
				}
				return $this->data[$one][$two];
			}
			return $this->data[$one];
		}
		if (! $one && ! $two && ! $three) {
			return $this->data;
		}
		return;
	}	


	/**
	 * return feedback and unset session variable
	 */
	public function getFeedback() {
		$session = new Session();
		return $this->data['session']['feedback'] = $session->getUnset('feedback');
	}	
	
	
	/**
	 */	
	public function pathView() { 
		return BASE_PATH . 'app/view/';
	}	
	
	/**
	 * return base url
	 */	
	public function urlHome() { 
		return $this->config->getUrl('base');
	}	
	
	
	/**
	 * return current url
	 */
	public function urlCurrent() {
		return $this->config->getUrl('current');
	}	
	
	
	public function urlPrevious() {
		return $this->config->getUrl('history');
	}	
	
	
	/**
	 * pull /asset/
	 */
	public function asset($ext = null) { 
		$base = $this->getUrl('base').'asset/';
		return ($ext == null ? $base : $base.$ext);
	}
	
	
	/**
	 * builds image url using filename
	 * @param  string $fileName from mainMedia data results
	 * @return string           url
	 */
	public function media($fileName) {

		if (is_file(BASE_PATH . 'img/upload/' . $fileName))
			return $this->config->getUrl('base') . 'img/upload/' . $fileName;
		else
			return 'http://placehold.it/200x200/';

	}
	
	
	// Convert String to a URL Friendly Version
	// public function urlFriendly($value = null)
	// {
	
	// 	// everything to lower and no spaces begin or end
	// 	$value = strtolower(trim($value));
		
	// 	// adding - for spaces and union characters
	// 	$find = array(' ', '&', '\r\n', '\n', '+',',');
	// 	$value = str_replace ($find, '-', $value);
		
	// 	//delete and replace rest of special chars
	// 	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	// 	$repl = array('', '-', '');
	// 	$value = preg_replace ($find, $repl, $value);
		
	// 	//return the friendly str
	// 	return $value; 	
		
	// }
	 

	// performs explode() on a string with the given delimiter and trims all whitespace for the elements
	function explodeTrim($str, $delimiter = ',') { 
	    if ( is_string($delimiter) ) { 
	        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str)); 
	        return explode($delimiter, $str); 
	    } 
	    return $str; 
	} 


	public function latestTweet($user) {

		// XML
		$xml = simplexml_load_file("http://twitter.com/statuses/user_timeline/$user.xml?count=1");
		echo $xml->status->text[0];
	}


	public function urlTag($ext = null) { 
		$base = $this->getUrl('base').$this->getUrl(1).'/tags/';
		return ($ext == null ? $base : $base.$ext);
	}


	public function logoMvc() {

		// logic here to add or remove a class and title="Open Homepage"
		
		$html =   '<a href="'.$this->urlHome().'">'
				. '<img src="'.$this->urlMedia('i/logo.png').'">'
				. '</a>';
		echo $html;
	}


	// Returns body class
	public function bodyClass() { 

		$i = 1;
		$class = '';

		while ($this->getUrl($i)) {
			$class .= $this->getUrl($i) . ' ';
			$i ++;
		}

		return trim($class);


		if (!$this->getUrl(1))
			return 'home';
//		$val = ( ? $this->getUrl(1) : );
//		return ' class="'.$val.'"';
	}


	/**
	 * [setMeta description]
	 * @param array $meta filled with jucy meta information
	 */
	public function setMeta($metas) {
		foreach ($metas as $key => $meta) {
			if (array_key_exists($key, $this->meta)) {
				if (! $this->meta[$key])
					$this->meta[$key] = $metas[$key];
			} else {
				$this->meta[$key] = $metas[$key];
			}
		}
		return $this;
	}


	/**
	 * returns requested meta key
	 * @param  string $key meta key
	 * @return bool or string
	 */
	public function getMeta($key) {
		if (array_key_exists($key, $this->meta))
			return $this->meta[$key];
		return false;
	}
	
} 