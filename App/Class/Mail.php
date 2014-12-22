<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mail extends \OriginalAppName\View
{


	/**
	 * Swift_Mailer instance
	 * @var object
	 */
	protected $swiftMailer;


	protected $css;


	protected $tag = '{example-tag}';


	/**
	 * @return object 
	 */
	public function getSwiftMailer() {
	    return $this->swiftMailer;
	}
	
	
	/**
	 * @param object $swiftMailer 
	 */
	public function setSwiftMailer($swiftMailer) {
	    $this->swiftMailer = $swiftMailer;
	    return $this;
	}	


	public function __construct() {
		Parent::__construct();
		
		// mail transport
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
			->setUsername('martin.wyatt@gmail.com')
			->setPassword('google app password');
		$this->setSwiftMailer(Swift_Mailer::newInstance($transport));

		// pallete
		$mailPallete = new \OriginalAppName\Mail\Pallete;
		$this->view->setDataKey('mail\styles', $mailPallete);

		$this->set_css('asset/screen-email.css');

	}

/*
[
	'subject' => 'hi world',
	'from' => [
		'martin.wyatt@gmail.com' => 'Martin Wyatt'
	],
	'to' => [
		'martin.wyatt@gmail.com',
		'martin.wyatt@gmail.com'
	],
	'template' => 'path/to/template'
]

 */
	/**
	 * configures headers and sends mail out
	 * @param  array  $properties see requiredSendProperties for rules
	 * @return bool
	 */
	public function send($config)
	{

		// resource
		$mailer = $this->getSwiftMailer();
		$message = Swift_Message::newInstance($config['subject']);

		// ['email' => 'contact name']
		if (isset($config['from'])) {
			$message->setFrom($config['from'])
		}

		// ['email', 'email']
		if (isset($config['to'])) {
			$message->setTo($config['to'])
		}

		// html?
		if (isset($config['template'])) {
			$body = $this->getTemplate($config['template']);
			$message->setBody($body);
		}

		// send
		$result = $mailer->send($message);

		// store
		if (! $result) {
			return;
		}

		// store
		$entityMail = new \OriginalAppName\Entity\Mail;
		$entityMail
			->setTo($config['to'])
			->setFrom($config['from'])
			->setSubject($config['subject'])
			->setBody($body)
			->setTimeSent(time());
		$model = new \OriginalAppName\Model\Mail;
		$model->create([$entityMail]);

		// positive
		return true;
	}


	/**
	 * grabs css file contents and stores as array
	 * @param string $path path to css file
	 */
	public function setCss($path)
	{
		$css = file_get_contents(BASE_PATH . '/' . $path);
		$cssSelectors = explode('}', $css);
		$symbolOpeningCurly = '{';
		$symbolDot = '.';
		$finalCss = [];
		foreach ($cssSelectors as $cssSelector) {

			// must contain a selector
			// or be a comment
			if (! strpos($cssSelector, $symbolOpeningCurly) || strpos($cssSelector, '@')) {
				continue;
			}

			// get '.foo-bar {' process to become 'foo-bar'
			$cssParts = explode($symbolOpeningCurly, $cssSelector);
			$selectorArea = current($cssParts);
			$positionDot = strrpos($selectorArea, $symbolDot);
			$positionCurly = strrpos($selectorArea, $symbolOpeningCurly);
			$selectorLength = $positionCurly - $positionDot;
			$selectorName = substr($selectorArea, $positionDot);
			$selectorName = trim(str_replace($symbolDot, '', $selectorName));
			
			// get css for this selector
			$selectorContent = substr($cssSelector, strpos($cssSelector, $symbolOpeningCurly));
			$selectorContent = trim(str_replace($symbolOpeningCurly, '', $selectorContent));

			// store as [foo-bar] = 'padding: 0;'
			$finalCss[$selectorName] = $selectorContent;
		}
		$this->css = $finalCss;
	}


	/**
	 * goes through all styles and replaces any found {$key} with
	 * its appropriate css
	 */
	public function tagReplaceCss()
	{
		$body = $this->get_body();
		foreach ($this->getCss() as $key => $css) {
			$match = '{' . $key . '}';
			if (strpos($body, $match) === false) {
				continue;
			}
			$body = str_replace($match, $css, $body);
		}
		$this->set_body($body);
		return $this;
	}


	/**
	 * random html being used in emails, attempts to style
	 * all supported elements {foo-bar}
	 * @param  string $html 
	 * @return string       html with {keys}
	 */
	public function tagInject($html)
	{

		// supported elements
		// can this be worked out from pool of classes? yes.
		foreach ($this->getCss() as $selector => $properties) {
			$tag = '{' . $selector . '}';
			$find = '<' . $selector;
			$replace = $find . ' style="' . $tag . '"';
			if (strpos($html, $find) === false) {
				continue;
			}
			$html = str_replace($find, $replace, $html);
		}
		return $html;
	}


	public function getCss()
	{
		return $this->css;
	}


	/**
	 * get css selector
	 * @param  string $key foo-bar
	 * @return string      css properties
	 */
	public function getCssKey($key)
	{
		return isset($this->css[$key]) ? $this->css[$key] : '';
	}
}