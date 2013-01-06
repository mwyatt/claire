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
	
	
	/**
	 * prepare all core objects here and register
	 */	
	public function header() {
	
		$user = new mainUser($this->database, $this->config);
	
		// initiate menu

		$menu = new mainMenu($this->database, $this->config);
		$menu
			->setObject($user);
		
		//$menu->adminBuild();
		
		$option = new mainOption($this->database, $this->config);
		$option->select();		
		
		// register new objects

		$this->setObject(array($option, $menu));
		
	}

	
	/**
	 * load template file and prepare all objects for output
	 * @param  string $templateTitle 
	 * @return bool                
	 */
	public function loadTemplate($templateTitle)
	{			
	
		$path = BASE_PATH . 'app/' . 'view/' . $templateTitle . '.php';
		$path = strtolower($path);

		// reject unfound template

		if (!file_exists($path))
			return false;

		$this->template = $path;

		// prepare common models
		$this->header();
	
		// push objects to method scope
		foreach ($this->objects as $title => $object) :
		
			$$title = $object;
		
		endforeach;
	
		// start buffer

		ob_start();	
		
		// include template

		require_once($path);

		// create cache $templateTitle.html
		/*file_put_contents(
			BASE_PATH . 'app/' . 'cache/' . $templateTitle . '.html', ob_get_contents()
		);*/
		
		// end buffer and send

		ob_end_flush();	

		exit;
		
	}		
		

	
	/**
	 * return feedback and unset session variable
	 */
	public function getFeedback() {

		if ($this->getObject('Session')->get('feedback')) {

			$output = '';

			$feedback = $this->getObject('Session')->getUnset('feedback');
			
			if (is_array($feedback)) {

				$type = current($feedback);
				$message = end($feedback);

				$output .= '<div class="feedback hide ' . $type . '" title="Dismiss">';
				$output .= '<h2>' . $type . '</h2>';
				$output .= '<p>' . $message . '</p>';

			} else {

				$output .= '<div class="feedback hide" title="Dismiss">';
				$output .= '<p>' . $feedback . '</p>';

			}
			
			$output .= '<div class="clearfix"></div>';
			$output .= '</div>';

			return $output;
			
		}

		return false;

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
	
} 