<?php

if (array_key_exists('method', $_GET)) {
	if ($_GET['method'] == 'group') {
		if (array_key_exists('player_id', $_GET)) {
			$encounter = new ttEncounterPart($database, $config);
			$encounter->readChange($_GET['player_id']);
			echo json_encode($encounter->getData());
			exit;
		}
	}
	if ($_GET['method'] == 'row') {
		if (array_key_exists('player_id', $_GET)) {
			$encounter = new ttEncounterPart($database, $config);
			$encounter->read($_GET['player_id']);
			echo json_encode($encounter->getData());
			exit;
		}
	}
}