<?php

require_once('ajax.php');

if ($_POST) {

	$id = (array_key_exists('id', $_POST) ? $_POST['id'] : false);
	$type = (array_key_exists('type', $_POST) ? $_POST['type'] : false);
	
	if (($id) && ($type)) {
		if (   ($type == 'post')
			|| ($type == 'page')
			|| ($type == 'project')
		) {				
			require_once('../../../model/content.php');
			$content = new Content();
			echo $content->toggleVisibility($id);
		}
	}
}