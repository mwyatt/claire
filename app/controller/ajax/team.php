<?php

$output = '';

// get teams by division id

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

echo $output;