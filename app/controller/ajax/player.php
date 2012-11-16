<?php

$output = '';

// get teams by division id

if (array_key_exists('all', $_POST)) {

	$ttPlayer = new ttPlayer($database, $config);

	$ttPlayer->read();

	if ($ttPlayer->getData()) {	

		$output .= '<option value="0"></option>';

		$index = 1;

		while ($ttPlayer->nextRow()) {
	
			$output .= '<option value="' . $ttPlayer->getRow('id') . '">' . $ttPlayer->getRow('full_name') . '</option>';

			$index ++;

		}

	}

}

echo $output;