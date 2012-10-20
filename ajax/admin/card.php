<?php

require_once('../init.php');

if (array_key_exists('division_id', $_POST) ? $_POST['id'] : false) {

	return 'division_id set and this has been returned';

}