<?php

$output = '';

if (array_key_exists('method', $_GET) && array_key_exists('type', $_GET) && array_key_exists('title', $_GET)) {

	$index = 1;
	$duplicate = true;

	$post = new Post($database, $config);
	$post->readByType($_GET['type']);
	$tool = new Tool($database, $config);

	if (! $title = $tool->urlFriendly($_GET['title']))
		exit;

	while ($duplicate == true) {

		$duplicate = false;

		if ($post->getData()) {
			while ($post->nextRow()) {

				if ($title == $post->getRow('title_slug')) {

					$duplicate = true;
					$index ++;
					$title .= '-' . $index;

				}

			}
		}

	}

	echo $title;

}

echo $output;



/*	function checkTitle($post, $title, $index = 1, $success = true) {

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

	}*/