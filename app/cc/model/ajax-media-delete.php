<?php

require_once('ajax.php');
require_once('../../model/media.php');


// Objects
$media = new Media();

echo '<pre>';
print_r ($_POST);
echo '</pre>';
exit;

if ($_POST) {		

	if (array_key_exists('id', $_POST)) {
	
		$media->get($_POST['id']);
		
		
		// 1 result
		foreach ($media->getResult() as $file) {
		
			if (@unlink('../../../../'.$media->dir.$file['filename'])) {
				
				echo ($media->delete($_POST['id']) ? 'Success' : '');
				
			}	
	
		}
	
	}
	
	// return false
	
}