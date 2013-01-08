<?php

$output = '';

if (array_key_exists('division_id', $_GET)) {

	$ttTeam = new ttTeam($database, $config);

	$ttTeam->readByDivision($_GET['division_id']);

	if ($ttTeam->getData()) {	

		$output .= '<option value="0"></option>';

		while ($ttTeam->nextRow()) {
	
			$output .= '<option value="' . $ttTeam->getRow('team_id') . '">' . $ttTeam->getRow('team_name') . '</option>';

		}

	}

}

if (array_key_exists('team_id', $_GET)) {

	$ttPlayer = new ttPlayer($database, $config);

	$ttPlayer->readByTeam($_GET['team_id']);

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