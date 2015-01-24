<?php

namespace OriginalAppName;


/**
 * commonly used and helpful functions
 * static because they should be
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Helper
{


	/**
	 * check multiple array keys exist in an array
	 * @param  array $keys  
	 * @param  array $array 
	 * @return bool        
	 */
	public static function arrayKeyExists($keys, $array)
	{
		foreach ($keys as $key) {
			if (array_key_exists($key, $array)) {
				continue;
			}
			return;
		}
		return true;
	}


	/**
	 * bats back a random string, good for unique codes
	 * @param  integer $length how big is the code?
	 * @return string          
	 */
	public static function getRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	

	/**
	 * performs explode() on a string with the given delimiter
	 * and trims all whitespace for the elements
	 */
	public static function explodeTrim($str, $delimiter = ',') { 
	    if ( is_string($delimiter) ) { 
	        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str)); 
	        return explode($delimiter, $str); 
	    } 
	    return $str; 
	} 


	/**
	 * friendly url building
	 * @param  string $value 
	 * @return string        one you can be friends with
	 */
	public static function urlFriendly($value = '')
	{
		return Helper::slugify($value);
	}


	/**
	 * better than urlfriendly because & becomes 'amp' then when 
	 * making urls it can be translated?
	 * @param  string $slug 
	 * @return string       foo-bar
	 */
	public static function slugify($slug)
	{
	    $slug = preg_replace('/\xE3\x80\x80/', ' ', $slug);
	    $slug = str_replace('-', ' ', $slug);
	    $slug = preg_replace('#[:\#\*"@+=;!><&\.%()\]\/\'\\\\|\[]#', "\x20", $slug);
	    $slug = str_replace('?', '', $slug);
	    $slug = trim(mb_strtolower($slug, 'UTF-8'));
	    $slug = preg_replace('#\x20+#', '-', $slug);
	    return $slug;
	}


	/**
	 * takes 1 dimensional array and converts to an object
	 * @param  array $array 
	 * @return object        
	 */
	public static function convertArrayToObject($array)
	{
		$object = new StdClass();
		foreach ($array as $key => $value) {
			$object->$key = $value;
		}
		return $object;
	}


	/**
	 * converts a delimiter seperated string to camelCase
	 * @param  string $delimiter the seperator for the original string
	 * @param  string $value     
	 * @return string            
	 */	
	public static function delimiterToCamel($value, $delimiter = '_')
	{

		// return passed value if no delimiter present
		if (strpos($value, $delimiter) === false) {
			return $value;
		}

		// initiate for concatenation
		$newValue = '';

		// mashes it together with each word as uppercase first
		foreach (explode($delimiter, $value) as $value) {
			$newValue .= ucfirst($value);
		}

		// always returns a camelcase
		return lcfirst($newValue);
	}
	

	/**
	 * accepts html and returns minified (no whitespace)
	 * @param  string $html html
	 * @return string         
	 */
	public static function htmlSanitise($html = '')
	{
		$search = array(
		    '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		    '/[^\S ]+\</s',  // strip whitespaces before tags, except space
		    '/(\s)+/s'       // shorten multiple whitespace sequences
		);
		$replace = array(
		    '>',
		    '<',
		    '\\1'
		);
		$html = preg_replace($search, $replace, $html);
		return $html;
	}
}
