<?php require_once('../init.php'); ?>

<?php

$output = '';

if (array_key_exists('division_id', $_POST)) {

	$ttTeam = new ttTeam($database, $config);

	$ttTeam->selectByDivision($_POST['division_id']);

	if ($ttTeam->getData()) {	

		$output .= '<option value="0"></option>';

		while ($ttTeam->nextRow()) {
	
			$output .= '<option value="' . $ttTeam->getRow('team_id') . '">' . $ttTeam->getRow('team_name') . '</option>';

		}

	}

}

if (array_key_exists('team_id', $_POST)) {

	$ttPlayer = new ttPlayer($database, $config);

	$ttPlayer->selectByTeam($_POST['team_id']);

	if ($ttPlayer->getData()) {	

		$output .= '<option value="0"></option>';

		$index = 1;

		while ($ttPlayer->nextRow()) {
	
			$output .= '<option label="' . $index . '" value="' . $ttPlayer->getRow('player_id') . '">' . $ttPlayer->getRow('player_name') . '</option>';

			$index ++;

		}

	}

}

echo $output;