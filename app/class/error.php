<?php

/**
 * Error handling
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Error
{
	
    private $debug;
	
	
    public function __construct($debug = 'no')
    {
        $this->debug = $debug;
		set_error_handler(array($this, 'handle'));
    }
	
	
    public function handle($errorType, $errorString, $errorFile, $errorLine)
    {
		switch ($this->debug)
		{
			case 'no':
				echo '<h1>A error has occurred. Please contact the administrator <a href="mailto:martin.wyatt@gmail.com">martin.wyatt@gmail.com</a></h1>';
				exit;		
			case 'yes':
				// build array
				$error['Line: ' . $errorLine]['Type'] = $errorType;
				$error['Line: ' . $errorLine]['Message'] = $errorString;
				$error['Line: ' . $errorLine]['File'] = $errorFile;
				
				// echo '<pre>';
				switch ($errorType) {
					case 2:
						print_r ($error);
						break;						
					case 8:
						print_r ($error);
						break;
					case 256:
						print_r ($error);
						break;
					case 512:
						print_r ($error);
						break;
					case 1024:
						print_r ($error);
						break;
					case 4096:
						print_r ($error);
						break;	
				}
				// echo '</pre>';
				break;
		}	
    }
}


/*

	Error
	
	@errortypes:
	
		2		E_WARNING
					Non-fatal run-time errors. Execution of the script is not halted

		8		E_NOTICE
					Run-time notices. The script found something that might be an error, but could also happen when running a script normally

		256		E_USER_ERROR
					Fatal user-generated error. This is like an E_ERROR set by the programmer using the PHP function trigger_error()

		512		E_USER_WARNING
					Non-fatal user-generated warning. This is like an E_WARNING set by the programmer using the PHP function trigger_error()

		1024	E_USER_NOTICE
					User-generated notice. This is like an E_NOTICE set by the programmer using the PHP function trigger_error()

		4096
					E_RECOVERABLE_ERROR	Catchable fatal error. This is like an E_ERROR but can be caught by a user defined handle (see also set_error_handler())

		8191	E_ALL
					All errors and warnings (E_STRICT became a part of E_ALL in PHP 5.4)	
					
*/					