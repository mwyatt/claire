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
	
		$user = new MainUser($this->database, $this->config);
	
		// initiate menu
		$menu = new MainMenu($this->database, $this->config);
		
		//$menu->adminBuild();
		
		$option = new MainOption($this->database, $this->config);
		$option->select();		
		
		// register new objects
		$this->setObject(array($option, $menu));
		
	}

	
	/**
	 * load template file and prepare all object results for output
	 */	
	public function loadTemplate($templateTitle)
	{			
	
		$path = BASE_PATH . 'app/' . 'view/' . $templateTitle . '.php';
		$path = strtolower($path);
		$this->template = $path;

		// prepare common models
		$this->header();
	
		// push objects to method scope
		foreach ($this->objects as $title => $object) :
		
			echo 'var $' . $title . ' set' . '<br>';
			
			$$title = $object;
		
		endforeach;
	
		// start buffer
		ob_start();	
		
		echo 'requiring template' . $path;

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

		if (array_key_exists('feedback', $_SESSION)) {
		
			$feedback = $_SESSION['feedback'];
			$_SESSION['feedback'] = false;
			
			return $feedback;
			
		} else {
		
			return false;
		
		}
		
	}	
	
	
	/**
	 */	
	public function dirView() { 
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
	public function urlCurrent($ext = null) {
		$url = implode('/', $this->config->getUrl()).'/';
		return $this->config->getUrl('base') . $url;
	}	
	
	
	/**
	 * pull /asset/
	 */
	public function asset($ext = null) { 
		$base = $this->getUrl('base').'asset/';
		return ($ext == null ? $base : $base.$ext);
	}
	
	
	/**
	 * pull /image/
	 */
	public function image($ext = null) { 
		$base = $this->getUrl('base').'image/';
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