<?php

namespace OriginalAppName\Session\Admin;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
abstract class Expire extends \OriginalAppName\Session
{


	/**
	 * refreshes the expiry time
	 * @return bool 
	 */
	public function refreshExpire()
	{

		// set expire again if not expired
		if ($this->getData('expire') > time()) {
			return $this->setExpire();
		}

		// delete session it has expired!
		$this->delete();
	}


	public function isExpire()
	{
		return $this->getData('expire') > time();
	}


	/**
	 * sets the expire time, 1 hour after last check!
	 */
	public function setExpire()
	{
		return $this->set('expire', time() + $this->getTime('hour') / 2);
	}
}