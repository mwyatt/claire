<?php

// Boot
require_once('ajax.php');
require_once('../../../model/content.php');


// Logic
if (array_key_exists('count', $_POST)) {

	$posts = new Content($DBH);

	$posts->countRows('post');

	/*
	1. count total posts
	2. query db
		count+1, count+1+perPage
	3. use result to append to the <ul>
	*/
	
}