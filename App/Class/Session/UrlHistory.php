<?php

namespace OriginalAppName\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class UrlHistory extends \OriginalAppName\Session
{


	protected $scope = 'OriginalAppName\Session\UrlHistory';


	protected $invalidWords = [
		'ajax',
		'asset'
	];


	/**
	 * gets the last but not the latest val
	 * @return string url
	 */
	public function getLatest() {
		$currentHistory = $this->getData();
		end($currentHistory);
		return prev($currentHistory);
	}


	/**
	 * adds to the session array to keep a record of your request history
	 * @todo should $this->data be array() as default?
	 */
	public function append($url)
	{
		if (! $this->validate($url)) {
			return;
		}

		// first one
		if (! $currentHistory = $this->getData()) {
			$currentHistory = [];
		}

		// check that the record does not breach 20
		if (count($currentHistory) > 19) {
			array_shift($currentHistory);
		}

		// check that next request is unique
		if (end($currentHistory) == $url) {
			return;
		}

		// adds to the array
		$currentHistory[] = $url;
		return $this->setData($currentHistory);
	}


	/**
	 * searches a url for invalid key words in a url, this way the history is
	 * not stuffed with ajax requests (for example)
	 * @param  string $url 
	 * @return bool      
	 */
	public function validate($url)
	{
		foreach ($this->getInvalidWords() as $invalidWord) {
			if (strpos($url, $invalidWord) !== false) {
				return false;
			}
		}
		return true;
	}


	/**
	 * @return array 
	 */
	public function getInvalidWords() {
	    return $this->invalidWords;
	}
	
	
	/**
	 * @param array $invalidWords 
	 */
	public function setInvalidWords($invalidWords) {
	    $this->invalidWords = $invalidWords;
	    return $this;
	}
}
