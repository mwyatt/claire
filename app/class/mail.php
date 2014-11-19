<?php

namespace OriginalAppName;


// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  ->setUsername('martin.wyatt@gmail.com')
  ->setPassword('google app password')
  ;

/*
You could alternatively use a different transport such as Sendmail or Mail:

// Sendmail
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

// Mail
$transport = Swift_MailTransport::newInstance();
*/

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance('Wonderful Subject')
  ->setFrom(array('martin.wyatt@gmail.com' => 'MVC'))
  ->setTo(array('martin.wyatt@gmail.com'))
  ->setBody('Here is the message itself')
  ;

// Send the message
$result = $mailer->send($message);

echo '<pre>';
print_r($result);
echo '</pre>';
exit;

result == 1




/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mail
{


	/**
	 * mail headers stored here, processed at setHeaders
	 * @var string
	 */
	public $headers;


	/**
	 * full address of the sender, should this come from the database?
	 * @var string
	 */
	public $addressFrom = 'localhost@localhost.com';


	/**
	 * validates the incoming properties array when sending mail
	 * not really needed?
	 * @var array
	 */
	public $requiredSendProperties = array(
		'to' => '',
		'subject' => '',
		'template' => ''
	);


	/**
	 * @var object
	 */
	public $view;


	/**
	 * used to allow setting of the mail pallete to the parser
	 * @param object $database 
	 * @param object $config   
	 * @param object $view     
	 */
	public function __construct($database, $config, $view) {

		// system objects
		parent::__construct($database, $config);
		$this->view = $view;

		// pallete
		$mailPallete = new \OriginalAppName\Pallete($this);
		$mailPallete->setSassStyles();
		$mailPallete->setStyles();
		$this->view->setDataKey('styles', $mailPallete);
	}


	
	/**
	 * builds header string for mail function
	 * @param object $properties 
	 */
	public function setHeaders($properties)
	{
		$headerSections = array(
			'From: ' . $this->addressFrom,
			'Reply-To: '. $this->addressFrom,
			'MIME-Version: 1.0',
			'Content-Type: text/html; charset=ISO-8859-1'
		);
		$this->headers = implode("\r\n", $headerSections);
	}


	/**
	 * configures headers and sends mail out
	 * @param  array  $properties see requiredSendProperties for rules
	 * @return bool
	 */
	public function send($properties = array())
	{

		// make more usable as object
		$properties = Helper::convertArrayToObject($properties);

		// core headers for mail
		$this->setHeaders($properties);

		// build html
		$templateHtml = $this->view->getTemplate($properties->template);

		// debug
		if ($this->isDebug($this)) {
			echo '<pre>';
			print_r($templateHtml);
			echo '</pre>';
			exit;
		}

		// send it!
		if (mail($properties->to, $properties->subject, $templateHtml, $this->headers)) {

			// create database entry
			$mold = new Mold_Mail();
			$mold->addressed_to = $properties->to;
			$mold->addressed_from = $this->addressFrom;
			$mold->subject = $properties->subject;
			$mold->content = $templateHtml;
			$mold->time = time();
			$model = new Model_Mail($this);
			$model->create(array($mold));
			return true;
		}
	}
}
