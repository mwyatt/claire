<?php

try {	
		
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			main_user
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, email VARCHAR(50) NOT NULL
				, password VARCHAR(255) NOT NULL
				, date_registered TIMESTAMP DEFAULT NOW()
				, level TINYINT(1) UNSIGNED NOT NULL DEFAULT '1'
				, PRIMARY KEY (id)
			)
	");
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_user_meta
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, user_id INT UNSIGNED
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (user_id) REFERENCES main_user(id)
			)
	");

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_content
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
				, FOREIGN KEY (user_id) REFERENCES main_user(id)
			)
	");

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_content_meta
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, content_id INT UNSIGNED
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (content_id) REFERENCES main_content(id)
			)
	");

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_option
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, name VARCHAR(255) NOT NULL
				, value VARCHAR(255) NOT NULL
				, PRIMARY KEY (id)
			)
	");	

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_media_tree
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, title_slug VARCHAR(255) NOT NULL
				, parent_id INT UNSIGNED									
				, PRIMARY KEY (id)
			)		
	");

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_media
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
				, FOREIGN KEY (media_tree_id) REFERENCES main_media_tree(id)	
			)		
	");

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_content_media
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, content_id INT UNSIGNED
				, media_id INT UNSIGNED
				, position INT UNSIGNED
				, PRIMARY KEY (id)
				, FOREIGN KEY (content_id) REFERENCES main_content(id)
				, FOREIGN KEY (media_id) REFERENCES main_media(id)
			)
	");	

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_ads
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
				, FOREIGN KEY (media_id) REFERENCES main_media(id)
			)
	");	

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_menu
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, title VARCHAR(255) NOT NULL
				, parent_id INT UNSIGNED									
				, guid VARCHAR(255) NOT NULL
				, position INT UNSIGNED									
				, type VARCHAR(20) DEFAULT 'main'
				, PRIMARY KEY (id)
			)		
	");

	// Table Tennis
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_archive
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, season VARCHAR(20) NOT NULL
				, html VARCHAR(8000)
				, PRIMARY KEY (id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_division
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, name VARCHAR(20) NOT NULL
				, PRIMARY KEY (id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_venue
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, name VARCHAR(75) NOT NULL
				, address VARCHAR(200) NOT NULL
				, PRIMARY KEY (id)
			)		
	");		
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_team
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, name VARCHAR(75) NOT NULL
				, home_night TINYINT(1)
				, venue_id INT UNSIGNED NOT NULL
				, division_id INT UNSIGNED NOT NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (division_id) REFERENCES tt_division(id)
				, FOREIGN KEY (venue_id) REFERENCES tt_venue(id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_player
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, first_name VARCHAR(75)
				, last_name VARCHAR(75)
				, rank INT UNSIGNED
				, team_id INT UNSIGNED NOT NULL
				, PRIMARY KEY (id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_fixture
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, team_left_id INT UNSIGNED NOT NULL
				, team_right_id INT UNSIGNED NOT NULL
				, date_fulfilled TIMESTAMP NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (team_left_id) REFERENCES tt_team(id)
				, FOREIGN KEY (team_right_id) REFERENCES tt_team(id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_encounter_part
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, player_id VARCHAR(100)
				, player_score TINYINT UNSIGNED
				, player_rank_change TINYINT
				, PRIMARY KEY (id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_encounter
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, part_left_id INT UNSIGNED
				, part_right_id INT UNSIGNED
				, fixture_id INT UNSIGNED NOT NULL
				, PRIMARY KEY (id)
				, FOREIGN KEY (part_left_id) REFERENCES tt_encounter_part(id)
				, FOREIGN KEY (part_right_id) REFERENCES tt_encounter_part(id)
				, FOREIGN KEY (fixture_id) REFERENCES tt_fixture(id)
			)		
	");	



	
} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Tables</h1>';
	echo $e;
	
}