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
	 * register new objects here and add to the collection
	 */	
	public function registerObjects($objects) {
	
		foreach ($objects as $object) :
		
			// get class title in lowercase
			$classTitle = strtolower(get_class($object));
			
			/*if ($classTitle == 'content')	
				$classTitle = $object->getType()*/
			
			// store object
			$this->data[$classTitle] = $object;
			
		endforeach;
		
		return $this;
		
	}
	
	
	/**
	 * prepare all core objects here and register
	 */	
	public function header() {
	
		$user = new User($this->database, $this->config);
	
		// initiate main menu
		$menu = new Menu($this->database, $this->config);
		
		//$menu->adminBuild();
		
		$options = new Options($this->database, $this->config);
		$options->select();		
					
		// register new objects
		$this->registerObjects(array($options, $menu));
		

		
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
		foreach ($this->data as $title => $object) :
		
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

		if (array_key_exists('feedback', $_SESSION)) {
		
			$feedback = $_SESSION['feedback'];
			$_SESSION['feedback'] = false;
			
			return $feedback;
			
		} else {
		
			return false;
		
		}
		
	}	
	
	
	/**
	 * return base url
	 */	
	public function urlHome() { 
		return $this->config->getUrlBase();
	}	
	
	
	/**
	 * return current url
	 */
	public function urlCurrent($ext = null) { 
		$url = $this->getUrl();
		$base = $this->getUrlBase();
		$url = implode('/', $url).'/';
		return ($ext == null ? $base.$url : $base.$url.$ext);
	}	
	
	
	
	
	
	
	
	
	

	
	
	/**
	 * pull /asset/
	 */
	public function asset($ext = null) { 
		$base = $this->getUrlBase().'asset/';
		return ($ext == null ? $base : $base.$ext);
	}
	
	
	/**
	 * pull /image/
	 */
	public function image($ext = null) { 
		$base = $this->getUrlBase().'image/';
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








	/*public function ccMediaUrl($ext = null) { 
		$base = $this->getUrlBase().'cc/view/assets/';
		return ($ext == null ? $base : $base.$ext);
	}*/


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