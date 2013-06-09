ALTER TABLE tt_player
ADD etta_license_number VARCHAR(10) NOT NULL DEFAULT ''

CREATE TABLE IF NOT EXISTS 
	main_user_action
	(
		id INT UNSIGNED NOT NULL AUTO_INCREMENT
		, description VARCHAR(255) NOT NULL DEFAULT ''
		, user_id INT UNSIGNED
		, time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		, action VARCHAR(6) NOT NULL DEFAULT ''
		, PRIMARY KEY (id)
		, KEY (user_id)
	)


alter table main_user
	add first_name VARCHAR(75) NOT NULL DEFAULT ''
	, add last_name VARCHAR(75) NOT NULL DEFAULT ''