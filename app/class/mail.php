<?php

/**
 * Send Out Mail
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mail
{

	// variables
	public $headers;
	public $toAddress;
	public $fromAddress;
	public $subject;
	public $html;
	
	/**
	 * Constructor
	 * @returns true on send mail success false on failure
	 */	
	public function __construct($subject, $html)
	{
		$this->toAddress = 'martin.wyatt@gmail.com';
		$this->fromAddress = 'localhost@localhost.com';
		$this->subject = $subject;
		$this->html = $html;
		
		// Send Mail
		$this
			->setHeaders()
			->send();
	}

	
	/**
	 * Sends Mail
	 * @returns true on send mail success false on failure
	 */	
	public function send()
	{
		if ($this->toAddress && $this->fromAddress && $this->subject && $this->html) {
			
			// Send Mail
			return mail($this->toAddress, $this->fromAddress, $this->subject, $this->html);
			
			echo 'Mail Successfully Sent to '.$this->toAddress;
		} else {
		
			echo 'Failed to Send Mail';
		
			// Return
			return false;
		}
	}

	
	/**
	 * Sets Headers
	 * @returns true on send mail success false on failure
	 */	
	public function setHeaders()
	{
		$headers = 'From: '.$this->fromAddress."\r\n";
		$headers .= 'Reply-To: '.$this->fromAddress.''."\r\n";
		$headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
		$headers .= 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
		
		// Set Headers
		$this->headers = $headers;
		
		// Return
		return $this;
	}

	
}
// $mail = new Mail('Hi World 3', 'Sent through class!');


/*ini_set ("SMTP","martin.wyatt@gmail.com");
ini_set ("sendmail_from","martin.wyatt@gmail.com");*/

		
	/*	
function mailto($to, $from, $subject, $message){
return mail($to, $subject, $message, $headers);
}		
		
		
mailto('martin.wyatt@gmail.com', 'localhost@localhost.com', 'Subject Line', 'Body Text');*/