<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
  
  
/**
 * @see app_cc_model_media
 */ 
$media = new Media();
  
// Upload Attempt
if (array_key_exists('form_upload', $_POST)) {

	$media->upload($_FILES['media']);
	$route->home('cc/media/');
	
}
  
$media->get();


/**
  * view: media-index
  */
require_once('app/cc/view/media.php');
exit;