<?php

namespace OriginalAppName\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Feedback extends \OriginalAppName\Session
{


	protected $scope = 'OriginalAppName\Session\Feedback';


	/**
	 * stores a message, pull this to show and remove
	 * @param string $message    
	 * @param string $type positive|negative|neutral
	 */
	public function setMessage($message, $type = 'neutral')
	{
		$this
			->set('message', ucfirst($message) . '.')
			->set('type', $type);
	}


	public function getMessage()
	{
		return ['message' => $this->get('message'), 'type' => $this->get('type')];
	}
}
