<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Search extends Model
{

	/**
	  *	@return true on matching word or false
	  */
	public static function title($data)
	{		

		$data['title'] = strtolower($data['title']);
		$_POST['search'] = strtolower($_POST['search']);

		$titleWords = explode(' ', $data['title']); // split via ' '
		$searchWords = explode(' ', $_POST['search']); // split via ' '

		foreach ($titleWords as $titleWord) {
			foreach ($searchWords as $searchWord) {
			
				// each word matches and !== null
				if (
					($titleWord)
					&& ($searchWord)
					&& (strpos($titleWord, $searchWord) !== false)
				) {
					return true;
				}
			
			}
		}
		return false;
	}	
	
}


/*
				// true | false
				$match = ( ? true : false);			
			if ($match == true) {
				
			}
*/