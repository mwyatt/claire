<?php

if (array_key_exists('team_id', $_GET)) {
	$player = new ttPlayer($database, $config);
	$player->readByTeam($_GET['team_id']);
	echo json_encode($player->getData());
	exit;
}

$output = '';

// get teams by division id

if (array_key_exists('all', $_POST)) {

	$ttPlayer = new ttPlayer($database, $config);

	$ttPlayer->read();

	if ($ttPlayer->getData()) {	

		$output .= '<option value="0">Absent</option>';

		$index = 1;

		while ($ttPlayer->nextRow()) {
	
			$output .= '<option value="' . $ttPlayer->getRow('id') . '">' . $ttPlayer->getRow('full_name') . '</option>';

			$index ++;

		}

	}

}

echo $output;