<?php

try {	
		
	// user
	$DBH->query("
		CREATE TABLE IF NOT EXISTS user
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, email VARCHAR(50) NOT NULL
				, password VARCHAR(255) NOT NULL
				, date_registered TIMESTAMP DEFAULT NOW()
				, level TINYINT(1) UNSIGNED NOT NULL DEFAULT '1'
				, PRIMARY KEY (id)
			)
	");
	echo 'Table \'user\' Installed';
	
	// user_meta
	$DBH->query("
		CREATE TABLE IF NOT EXISTS user_meta
			(
				meta_id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, user_id INT UNSIGNED
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (meta_id)
				, FOREIGN KEY (user_id) REFERENCES user(id)
			)
	");
	echo 'Table \'user_meta\' Installed';
	
	
	// content
	$DBH->query("
		CREATE TABLE IF NOT EXISTS content
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, title_slug VARCHAR(255) NOT NULL
				, html VARCHAR(8000)
				, type VARCHAR(50) NOT NULL
				, date_published TIMESTAMP DEFAULT NOW()
				, guid VARCHAR(255) NOT NULL
				, status VARCHAR(50) NOT NULL DEFAULT 'invisible'
				, user_id INT UNSIGNED				
				, PRIMARY KEY (id)
				, FOREIGN KEY (user_id) REFERENCES user(id)					
			)
	");
	echo 'Table \'content\' Installed';
	
	
	// content_meta
	$DBH->query("
		CREATE TABLE IF NOT EXISTS content_meta
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, content_id INT UNSIGNED
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (content_id) REFERENCES content(id)
			)
	");
	echo 'Table \'content_meta\' Installed';
	
	
	// options
	$DBH->query("
		CREATE TABLE IF NOT EXISTS options
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
			)
	");	
	echo 'Table \'options\' Installed';
	
	
	// media_tree
	$DBH->query("
		CREATE TABLE IF NOT EXISTS media_tree
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, title_slug VARCHAR(255) NOT NULL
				, parent_id INT UNSIGNED									
				, PRIMARY KEY (id)
			)		
	");
	echo 'Table \'media_tree\' Installed';
	
	
	// media
	$DBH->query("
		CREATE TABLE IF NOT EXISTS media
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, title_slug VARCHAR(255) NOT NULL
				, guid VARCHAR(255) NOT NULL	
				, date_published TIMESTAMP DEFAULT NOW()	
				, description VARCHAR(255) NOT NULL
				, filename VARCHAR(255) NOT NULL
				, type VARCHAR(50) NOT NULL
				, media_tree_id INT UNSIGNED
				, PRIMARY KEY (id)
				, FOREIGN KEY (media_tree_id) REFERENCES media_tree(id)	
			)		
	");
	echo 'Table \'media\' Installed';
	
	
	// content_media
	$DBH->query("
		CREATE TABLE IF NOT EXISTS content_media
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, content_id INT UNSIGNED
				, media_id INT UNSIGNED
				, position INT UNSIGNED
				, PRIMARY KEY (id)
				, FOREIGN KEY (content_id) REFERENCES content(id)
				, FOREIGN KEY (media_id) REFERENCES media(id)
			)
	");	
	echo 'Table \'content_media\' Installed';
	
	
	// ads
	$DBH->query("
		CREATE TABLE IF NOT EXISTS ads
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, html VARCHAR(8000)
				, target VARCHAR(255)
				, type VARCHAR(50) NOT NULL
				, status VARCHAR(50) NOT NULL DEFAULT 'invisible'
				, position INT UNSIGNED
				, media_id INT UNSIGNED				
				, PRIMARY KEY (id)
				, FOREIGN KEY (media_id) REFERENCES media(id)					
			)
	");	
	echo 'Table \'ads\' Installed';
	
	
	
	
	/*
	// menu
	$DBH->query("
		CREATE TABLE IF NOT EXISTS
			menu
				(
					id INT UNSIGNED NOT NULL AUTO_INCREMENT
					, title VARCHAR(255) NOT NULL
					, guid VARCHAR(255) NOT NULL
					, PRIMARY KEY (id)
				)		
		`menu`
		(
			`id` INT(11) NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(75) DEFAULT NULL,
			`guid` VARCHAR(100) DEFAULT NULL,
			`content_id` INT(11) DEFAULT NULL,
			`parent_id` INT(11) DEFAULT NULL,
			`position` INT(11) DEFAULT NULL,
			`type` VARCHAR(20) DEFAULT NULL,
			PRIMARY KEY (`id`)
		)
	");
	*/


	
} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Tables</h1>';
	echo $e;
	
}