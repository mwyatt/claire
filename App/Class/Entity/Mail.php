<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="mail")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Mail extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
     * @Column(type="string")
	 * @var string
	 */
	protected $to;


	/**
     * @Column(type="string")
	 * @var string
	 */
	protected $from;


	/**
     * @Column(type="string")
	 * @var string
	 */
	protected $subject;


	/**
     * @Column(type="text")
	 * @var string
	 */
	protected $body;


	/**
     * @Column(type="integer")
	 * @var int
	 */
	protected $timeSent;


	/**
	 * @return string 
	 */
	public function getTo() {
	    return $this->to;
	}
	
	
	/**
	 * @param string $to 
	 */
	public function setTo($to) {
	    $this->to = $to;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getFrom() {
	    return $this->from;
	}
	
	
	/**
	 * @param string $from 
	 */
	public function setFrom($from) {
	    $this->from = $from;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getSubject() {
	    return $this->subject;
	}
	
	
	/**
	 * @param string $subject 
	 */
	public function setSubject($subject) {
	    $this->subject = $subject;
	    return $this;
	}


	/**
	 * @return string 
	 */
	public function getBody() {
	    return $this->body;
	}
	
	
	/**
	 * @param string $body 
	 */
	public function setBody($body) {
	    $this->body = $body;
	    return $this;
	}


	/**
	 * @return int epoch
	 */
	public function getTimeSent() {
	    return $this->timeSent;
	}
	
	
	/**
	 * @param int $timeSent epoch
	 */
	public function setTimeSent($timeSent) {
	    $this->timeSent = $timeSent;
	    return $this;
	}


	public function beforeSave()
	{
		$this->setTo(implode(', ', $this->getTo()));
		$this->setFrom(implode(', ', $this->getFrom()));
	}
}
