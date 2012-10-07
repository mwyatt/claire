<?php

try {	

	echo '<h1>Installing Database</h1>';

		
	// user
	$database->dbh->query("
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
	echo 'Table \'user\' Installed' . '<br>';
	
	// user_meta
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS user_meta
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, user_id INT UNSIGNED
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (user_id) REFERENCES user(id)
			)
	");
	echo 'Table \'user_meta\' Installed' . '<br>';
	
	
	// content
	$database->dbh->query("
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
	echo 'Table \'content\' Installed' . '<br>';
	
	
	// content_meta
	$database->dbh->query("
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
	echo 'Table \'content_meta\' Installed' . '<br>';
	
	
	// options
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS options
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
			)
	");	
	echo 'Table \'options\' Installed' . '<br>';
	
	
	// media_tree
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS media_tree
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, title_slug VARCHAR(255) NOT NULL
				, parent_id INT UNSIGNED									
				, PRIMARY KEY (id)
			)		
	");
	echo 'Table \'media_tree\' Installed' . '<br>';
	
	
	// media
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS media
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, title_slug VARCHAR(255) NOT NULL
				, guid VARCHAR(255) NOT NULL	
				, date_published TIMESTAMP DEFAULT NOW()	
				, description VARCHAR(255) NOT NULL
				, type VARCHAR(50) NOT NULL
				, media_tree_id INT UNSIGNED
				, PRIMARY KEY (id)
				, FOREIGN KEY (media_tree_id) REFERENCES media_tree(id)	
			)		
	");
	echo 'Table \'media\' Installed' . '<br>';
	
	
	// content_media
	$database->dbh->query("
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
	echo 'Table \'content_media\' Installed' . '<br>';
	
	
	// ads
	$database->dbh->query("
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
	echo 'Table \'ads\' Installed' . '<br>';
	
	
	// menu
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS menu
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, parent_id INT UNSIGNED									
				, guid VARCHAR(255) NOT NULL
				, position INT UNSIGNED									
				, type VARCHAR(20) DEFAULT 'main'
				, PRIMARY KEY (id)
				, FOREIGN KEY (content_id) REFERENCES content(id)				
			)		
	");
	echo 'Table \'menu\' Installed' . '<br>';
	
	
} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Tables</h1>';
	echo $e;
	
}