<?php
	$menu = new Menu(
		$DBH,
		$config->getUrlBase(),
		$config->getUrl()	
	);
			
	$view = new View(
		$config->getUrlBase(),
		$config->getUrl()
	);