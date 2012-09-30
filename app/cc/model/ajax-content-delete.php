<?php

require_once('ajax.php');
require_once('../../model/content.php');


// Objects
$content = new Content($DBH); 


if ($_POST) {		

	if (array_key_exists('id', $_POST)) {
	
		$content->delete($_POST['id']);
	
	}
	
	// return false
	
}