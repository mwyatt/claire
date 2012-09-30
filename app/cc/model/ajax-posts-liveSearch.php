<?php

// require
require_once('ajax.php');
require_once('../../model/search.php');
require_once('../../model/content.php');

// Objects
$content = new Content($DBH); 
$search = new Search();


if (array_key_exists('search', $_POST) && $_POST['search']) {
	
	$content->selectType($_POST['type']); // get all posts	
	
	$results = $content->getResult();
	$content->setResult(
		array_filter($results, array('search', 'title')
	));		
	
	if ($content->getResult()) {

		if ($content->getResult()) : foreach ($content->getResult() as $content) : extract($content);
		
			require('../../cc/view/resultRow-post.php');
			
		endforeach; endif;
	
	}
	
}
exit;