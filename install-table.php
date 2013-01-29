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
				, date_published INT
				, guid VARCHAR(255) NOT NULL
				, status VARCHAR(50) NOT NULL DEFAULT 'invisible'
				, user_id INT UNSIGNED				
				, PRIMARY KEY (id)
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

	// $database->dbh->query("
	// 	CREATE TABLE IF NOT EXISTS 
	// 		main_media_tree
	// 		(
	// 			id INT UNSIGNED NOT NULL AUTO_INCREMENT
	// 			, title VARCHAR(255) NOT NULL
	// 			, title_slug VARCHAR(255) NOT NULL
	// 			, parent_id INT UNSIGNED									
	// 			, PRIMARY KEY (id)
	// 		)		
	// ");

	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS 
			main_media
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, file_name VARCHAR(255) NOT NULL
				, title VARCHAR(255)
				, date_published INT UNSIGNED
				, type VARCHAR(50) NOT NULL
				, user_id INT UNSIGNED
				, PRIMARY KEY (id)
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
			tt_secretary
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, first_name VARCHAR(75)
				, last_name VARCHAR(75)
				, phone_landline VARCHAR(30)
				, phone_mobile VARCHAR(30)
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
				, secretary_id INT UNSIGNED
				, venue_id INT UNSIGNED NOT NULL
				, division_id INT UNSIGNED NOT NULL
				, PRIMARY KEY (id)
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
				, date_fulfilled INT
				, PRIMARY KEY (id)
			)		
	");	
	
	$database->dbh->query("
		CREATE TABLE IF NOT EXISTS
			tt_encounter_part
			(
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, player_id INT UNSIGNED
				, player_score TINYINT UNSIGNED
				, player_rank_change TINYINT
				, status VARCHAR(20)
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
			)		
	");	

	$database->dbh->query("	
		create view tt_encounter_result as

		select
			tt_encounter.id as encounter_id
			, tt_encounter_part_left.player_id as left_id
			, tt_encounter_part_right.player_id as right_id
			, tt_encounter_part_left.player_score as left_score
			, tt_encounter_part_right.player_score as right_score
			, tt_encounter_part_left.player_rank_change as left_rank_change
			, tt_encounter_part_right.player_rank_change as right_rank_change
			, tt_encounter.fixture_id
			, tt_encounter_part_left.status

		from tt_encounter

		left join tt_encounter_part as tt_encounter_part_left on tt_encounter_part_left.id = tt_encounter.part_left_id

		left join tt_encounter_part as tt_encounter_part_right on tt_encounter_part_right.id = tt_encounter.part_right_id

		group by tt_encounter.id
	");
	
	$database->dbh->query("	
		create view tt_fixture_result as

		select
			tt_fixture.id as fixture_id
			, team_left.id as left_id
			, team_right.id as right_id
			, sum(tt_encounter_result.left_score) as left_score
			, sum(tt_encounter_result.right_score) as right_score

		from tt_fixture

		left join tt_team as team_left on team_left.id = tt_fixture.team_left_id

		left join tt_team as team_right on team_right.id = tt_fixture.team_right_id

		left join tt_encounter_result on tt_encounter_result.fixture_id = tt_fixture.id

		where tt_fixture.date_fulfilled IS NOT NULL

		group by tt_fixture.id
	");

	
} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Tables</h1>';
	echo $e;
	
}