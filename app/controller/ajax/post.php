<?php

$output = '';

if (array_key_exists('method', $_GET)) {

	if ($_GET['method'] == 'slug') {

		$view = new View($database, $config);
		$post = new Post($database, $config);
		$post->readByType('press');

		// 

		$title = $view->urlFriendly($_GET['title']);
		// $titleParts = explode(' ', $_GET['title']);

		if ($post->getData()) {

		}


		$output .= $_GET['title'];

	}

}

/*	$ttPlayer = new ttPlayer($database, $config);

	$ttPlayer->read();

	if ($ttPlayer->getData()) {	

		$output .= '<option value="0"></option>';

		$index = 1;

		while ($ttPlayer->nextRow()) {
	
			$output .= '<option value="' . $ttPlayer->getRow('id') . '">' . $ttPlayer->getRow('full_name') . '</option>';

			$index ++;

		}

	}
*/

echo $output;