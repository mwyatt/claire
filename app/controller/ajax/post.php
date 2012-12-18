<?php

$output = '';

if (array_key_exists('method', $_GET)) {

	if ($_GET['method'] == 'slug') {

		$post = new Post($database, $config);
		$post->readByType('press');

		echo '<pre>';
		print_r($post);
		echo '</pre>';
		exit;
		


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