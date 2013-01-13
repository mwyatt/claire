<?php

if (array_key_exists('default', $_GET)) {

	$search = new Search($database, $config);

	if ($search->read($_GET['default']))
		echo $search->getData();

}