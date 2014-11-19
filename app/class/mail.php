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
}
