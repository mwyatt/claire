<?php


/**
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Timer extends Helper
{


	/**
	 * http
	 * @var string
	 */
	public $scheme;


	public function __construct() {}


	/**
	 * @return string 
	 */
	public function press()
	{
		microtime()
	}
}

/*

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

// Sleep for a while
usleep(100);

$time_end = microtime_float();
$time = $time_end - $time_start;

echo "Did nothing in $time seconds\n";

 */