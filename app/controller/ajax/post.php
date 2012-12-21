<?php

$output = '';

if (array_key_exists('method', $_GET) && array_key_exists('type', $_GET) && array_key_exists('title', $_GET)) {

	function checkTitle($post, $title, $index = 1, $success = true) {

		$view = new View($database, $config);
		$post = new Post($database, $config);
		$post->readByType('press');

		// 

		$title = $view->urlFriendly($_GET['title']);
		// $titleParts = explode(' ', $_GET['title']);

		if ($post->getData()) {

			while ($post->nextRow()) {

				if ($title == $post->getRow('title_slug')) {

					$index ++;
					$title .= '-' . $index;
					checkTitle($post, $title, $index);

				}

			}

		}

		return $title;

	}

	$post = new Post($database, $config);
	$tool = new Tool($database, $config);

	$title = $tool->urlFriendly($_GET['title']);

	if ($title) {

		$post->readByType($_GET['type']);

		while (! $newTitle = checkTitle($post, $title)) {}

		$output .= $newTitle;
		
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