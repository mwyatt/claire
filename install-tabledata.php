<?php

try {

	$epochTime = time();
	
	$mainuser
		->setEmail('martin.wyatt@gmail.com')
		->setPassword('123')
		->insert(10);
	$mainuser
		->setEmail('mike.turner@gmail.com')
		->setPassword('223')
		->insert(1);
	
	$database->dbh->query("
		INSERT INTO main_user_meta
			(user_id, name, value)
		VALUES
			('1', 'first_name', 'Martin')
			, ('1', 'last_name', 'Wyatt')
			, ('1', 'age', '24')
			, ('2', 'first_name', 'Mike')
			, ('2', 'last_name', 'Turner')
	");	

	$database->dbh->query("
		INSERT INTO main_content
			(title, title_slug, html, type, guid, status, user_id, date_published)
		VALUES
			('Example Post Title', 'example-post-title', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'press', 'http://localhost/posts/1/example-post-title-1/', 'visible', '1', $epochTime)
			, ('Example Post Title 2', 'example-post-title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'press', 'http://localhost/posts/1/example-post-title-1/', 'visible', '1', $epochTime)
			, ('Example Post Title 1', 'example-post-title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'press', 'http://localhost/posts/1/example-post-title-1/', 'visible', '1', $epochTime)
			, ('Example Post Title 2', 'example-post-title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'press', 'http://localhost/posts/2/example-post-title-2/', 'visible', '1', $epochTime)
			, ('Example Project Title 1', 'example-project-title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'project', 'http://localhost/projects/3/example-project-title-1/', 'visible', '1', $epochTime)
			, ('Example Project Title 2', 'example-project-title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'project', 'http://localhost/projects/4/example-project-title-2/', 'visible', '1', $epochTime)
			, ('Contact me', 'contact-me', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'page', 'http://localhost/mvc/contact-me/', 'visible', '1', $epochTime)
			, ('Local Clubs', 'local-clubs', '<section class=\"post_content clearfix\" itemprop=\"articleBody\"><table id=\"inner_menu\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td><a href=\"#1\">Hyndburn</a></td><td><a href=\"#2\">Whalley</a></td><td><a href=\"#3\">Rawtenstall</a></td><td><a href=\"#4\">Doals</a></td></tr></tbody></table><h2 id=\"1\">Hyndburn TT Club</h2><p>We offer coaching and competition for all ability levels – from beginner to advanced – we will be starting a junior league for teams and running individual competitions.</p><p><span style=\"font-size: 20px; font-weight: bold;\">Junior Session</span></p><p>We have now started a new junior club for young people interested in table tennis&nbsp;it’s held on Friday evenings. With two sessions&nbsp;5.00 till 6.30 primary age&nbsp;beginners/intermediate&nbsp;6.30 till 8.00 secondary age.</p><p>£2.00 per session</p><h2>Open Session</h2><ul><li>All Ages</li><li>Coaching Avaliable</li></ul><p>Wednesday 5:00 – 7:00</p><h2>Coaching and Competition</h2><p>We offer coaching and competition for all ability levels – from beginner to advanced – we will be starting a junior league for teams and running individual competitions.</p><p>If you don’t want to compete we will just offer coaching and facilities to practice and play just for fun.</p><p>Contact <a title=\"Welcome\" href=\"http://eastlancstt.org.uk/the-league/welcome/\">Mick Moir</a> for more information on 07531674059</p><h2>Future events</h2><ul><li>Junior League</li><li>Ladder</li></ul><hr><h2 id=\"2\">Whalley TT Club</h2><p style=\"text-align: center;\"><span style=\"font-size: 20px; font-weight: bold;\"><a title=\"Venues\" href=\"http://eastlancstt.org.uk/the-league/venues/\">Whalley Village Hall</a></span></p><p style=\"text-align: center;\">Wednesday evening 7.30 till 10.00</p><p style=\"text-align: center;\">Saturday 9.30 to 12.30</p><p>(during term time)</p><p style=\"text-align: left;\">For more information contact</p><h2 style=\"text-align: left;\">Eric Ronnan</h2><p style=\"text-align: left;\">Tel: 01254 822555</p><p>Email: ericronnan@whalleyvillagehall.org.uk</p><hr><h2 id=\"3\">Rawtenstall TT Club</h2><h2><a title=\"Venues\" href=\"http://eastlancstt.org.uk/the-league/venues/\">Kay Street Baptists Table Tennis Club</a></h2><div><p>Rawtenstall</p><p>Mondays 7.30 till 10.00</p><p>New players welcome</p><p>For more information contact</p><h3>Trevor Elkington</h3><p>Tel:&nbsp;01706 217786</p></div><p>&nbsp;</p><hr><h2 id=\"4\">Doals TT Club</h2><p style=\"text-align: center;\"><strong><span style=\"font-size: xx-large;\">WEIR Village</span></strong></p><p>BACUP</p><p style=\"text-align: center;\">(Based in Doals Community Centre</p><p style=\"text-align: center;\">Next to 193 Burnley Road, OL13 8RW)</p><p><a href=\"http://www.doalsttc.co.uk/\" rel=\"nofollow\" target=\"_blank\"><span style=\"color: #0066cc; font-family: Arial; font-size: medium;\">www.doalsttc.co.uk</span></a><span style=\"font-size: medium;\"><span style=\"color: navy; font-family: Arial;\">.</span></span></p><p style=\"text-align: center;\"><img src=\"http://eastlancstt.org.uk/archive/doals_tt_files/image002.jpg\" alt=\"\" width=\"353\" height=\"249\" border=\"0\"><strong></strong></p><p>MONDAYS &amp; WEDS 7.00 till 10.00</p><p style=\"text-align: center;\">(Mondays for league home games only during season)</p><p style=\"text-align: center;\">Top quality tables, designed sports lighting &amp; a high ceiling make us a great place to play table tennis.</p><p style=\"text-align: center;\"><strong>Wheelchair friendly &amp; open to all ages 11+</strong></p><p style=\"text-align: center;\"><strong><em>Members only</em> </strong>but if interested in becoming one ring or email:</p><p>Neil Hepworth 0787 383 4942</p><p>hepworth_neil@hotmail.com</p><hr></section>', 'page', '', 'visible', '1', $epochTime)
	");

	$database->dbh->query("
		INSERT INTO main_content_meta
			(content_id, name, value)
		VALUES
			('1', 'colour', 'Red')
			, ('1', 'price', '200')
			, ('1', 'attached', '1, 3, 2')
			, ('1', 'tags', 'Photoshop, HTML, ')
			, ('7', 'meta_title', 'Contact Me')
			, ('7', 'meta_keywords', 'contact, me, eastlancs')
	");	

	$database->dbh->query("
		INSERT INTO main_option
			(name, value)
		VALUES
			('meta_title', 'East Lancashire Table Tennis League')			
			, ('meta_keywords', 'table tennis, east lancashire, lancashire, ping pong, league, elttl, east lancashire table tennis league')
			, ('meta_description', 'Martin Wyatts Blog and Portfolio')
			, ('site_title', 'East Lancashire Table Tennis League')
			, ('site_email', 'martin.wyatt@gmail.com')			
			, ('site_social_twitter', 'http://twitter.com/mawyatt')
			, ('site_social_facebook', '')		
			, ('site_social_youtube', '')		
			, ('site_social_google', '')		
			, ('site_address_name', '')		
			, ('site_address_line1', '')		
			, ('site_address_line2', '')		
			, ('site_address_towncity', '')		
			, ('site_address_county', '')		
			, ('site_address_postcode', '')		
			, ('site_telephone', '')		
			, ('site_mobile', '')		
			, ('site_fax', '')	
			, ('thumb1', '50, 50')		
			, ('thumb2', '200, 200')		
			, ('thumb3', '500, 500')
	");	

	// $database->dbh->query("
	// 	INSERT INTO main_media_tree
	// 		(title, title_slug, parent_id)
	// 	VALUES
	// 		('Root', 'root', '')
	// 		, ('Artwork', 'artwork', '1')
	// 			, ('Cover', 'cover', '2')
	// 		, ('Product', 'product', '1')
	// 		, ('Temp', 'temp', '1')
	// ");	

	
/*				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, file_name VARCHAR(255) NOT NULL
				, title VARCHAR(255)
				, date_published INT UNSIGNED
				, type VARCHAR(50) NOT NULL
				, user_id INT UNSIGNED
				, PRIMARY KEY (id)*/
/*	$database->dbh->query("
		INSERT INTO main_media (
			file_name
			, title
			, date_published
			, type
			, user_id
		)
		VALUES
			('grandma-and-family.jpg', 'Grandma and Family', 'example-media-1', $epochTime, 'jpg', '1')
			, ('minutes-081112.pdf', 'Minutes 002', 'minutes-002', $epochTime, 'pdf', '2')
	");*/

	$database->dbh->query("
		INSERT INTO main_ads
			(title, html, target, type, status, position, media_id)
		VALUES
			('Example Advertisement 1', '<p>Example HTML Code</p>', 'http://localhost/mvc/example-link/', 'cover', 'visible', '1', '1')
			, ('Example Advertisement 2', '<p>Example HTML Code</p>', 'http://localhost/mvc/example-link/', 'cover', 'visible', '1', '1')
	");

	$database->dbh->query("
		INSERT INTO main_content_media
			(content_id, media_id, position)
		VALUES
			('1', '1', '2')
			, ('1', '2', '1')
	");	

	$database->dbh->query("
		INSERT INTO main_menu
			(title, guid, parent_id, position, type)
		VALUES
			('Home', 'http://localhost/mvc/', '0', '1', 'main')
			, ('Posts', 'http://localhost/mvc/posts/', '0', '2', 'main')
			, ('Contact', 'http://localhost/mvc/contact-me/', '0', '3', 'main')
	");	

	// Table Tennis
	
	$database->dbh->query("
		INSERT INTO
			tt_archive
			(season, html)
		VALUES
			('2011', '<h1>Example Content</h1>')
	");	

	$database->dbh->query("
		INSERT INTO
			tt_division
			(name)
		VALUES
			('Premier')
			, ('First')
			, ('Second')
			, ('Third')
	");	

	$database->dbh->query("
		INSERT INTO `tt_venue` (`id`, `name`, `address`) VALUES
		(2, 'Ramsbottom Cricket Club', '53.645636,-2.313649'),
		(1, 'Burnley Boys Club', '53.803642,-2.237198'),
		(3, 'Low Moor Club', '53.870917,-2.412058'),
		(4, 'East Lancashire Cricket Club', '53.75312,-2.498476'),
		(5, 'Hyndburn Leisure Centre', '53.755232,-2.385353'),
		(6, 'Kay Street Baptist Church', '53.702059,-2.283925'),
		(7, 'Whalley Village Hall', '53.820441,-2.405952'),
		(8, 'Methodist Church Brierfield', '53.824827,-2.234167'),
		(9, 'Adpak Machinery Systems', '53.836766,-2.237565'),
		(10, 'Doals Community Centre', '53.726808,-2.198435');
	");	

	$database->dbh->query("
		INSERT INTO `tt_secretary` (`id`, `first_name`, `last_name`, `phone_landline`, `phone_mobile`) VALUES
		(1, 'Graham', 'Young', '01706 220142', '07710 917055 '),
		(2, 'Bryan', 'Edwards', '01617 975082', NULL),
		(3, 'Peter', 'Marsland', '01282 430446', '07805761863'),
		(4, 'Ian', 'Howarth', '01254 245260', '07854 444697'),
		(5, 'Fred', 'Wade', '01282 789049', '07973 294690'),
		(6, 'Damon', 'Blezard', '', '07766140631'),
		(7, 'Doug', 'Argyle', '', '07894 552380'),
		(8, 'Matthew', 'Harrison', '01282 412840', '07870 918815'),
		(9, 'Wilton', 'Holt', '01706 825197', ''),
		(10, 'Phil', 'Mileham', '01200 425005', '07837 686746'),
		(11, 'Trev', 'Elkington', '01706 217786', '07981 387755 '),
		(12, 'Grant', 'Saggers', '', '07887 902466'),
		(13, 'John', 'Thornber', '01282 420856', '07979 907526 '),
		(14, 'Alan', 'Prudden', '01282 459672', '07773 958330 '),
		(15, 'Alan', 'Duckworth', '', '07949 061828 '),
		(16, 'Martin', 'Drury', '01254 823960', '07802876259'),
		(17, 'Paul', 'Wood', '01619 983703', '07714 097341 '),
		(18, 'Scott', 'Thompson', '01200 427747', '07972 482818 '),
		(19, 'Martin', 'Ormsby', '01254 393726', '07805683093'),
		(20, 'Chris', 'Booth', '', '07429 114793 '),
		(21, 'Mike', 'Hindle', '01254 703291', '07710 596735 '),
		(22, 'Michael', 'Moir', '', '07531 674059 '),
		(23, 'John', 'Farrow', '01282 601444', '07887 751172 '),
		(24, 'Phil', 'Grace', '01254 825552', '07889 168135 '),
		(25, 'Kim', 'Croyden', '01200 427655', ''),
		(26, 'Neil', 'Hepworth', '01706 874636', '07873 834942 '),
		(27, 'Felicity', 'Pickard', '01282 710499', '07528 495795 '),
		(28, 'Ross', 'Erwin', '01706 211365', '07703 475648 '),
		(29, 'Eric', 'Ronnan', ' 01254 822555', ''),
		(30, 'Ryan', 'Monk', '01200 423191', '07583153457'),
		(31, 'Duncan', 'Taylor', '01706 223757', '07733 128483 '),
		(32, 'Bernard', 'Mills', '01706 877391', '07881 610874'),
		(34, 'Harry', 'Rawcliffe', '01254 663451', NULL),
		(36, 'Bob', 'Walker', '01282 685128', '07505 147363'),
		(37, 'Ged', 'Simpson', '01254 237381', ' 07519 553139  '),
		(39, 'Eric', 'Ronnan', '01254 822555', NULL);
	");	

	$database->dbh->query("
		INSERT INTO `tt_team` (`id`, `name`, `home_night`, `secretary_id`, `venue_id`, `division_id`) VALUES
		(1, 'Clitheroe LMC', 4, 18, 3, 2),
		(2, 'Hyndburn TTC A', 3, 1, 5, 1),
		(3, 'Ward & Stobbart', 1, 37, 5, 1),
		(4, 'Burnley Boys Club', 1, 8, 1, 1),
		(5, 'Ramsbottom A', 2, 2, 2, 1),
		(6, 'Ramsbottom B', 2, 9, 2, 1),
		(7, 'Rovers', 3, 6, 5, 1),
		(8, 'East Lancs', 3, 4, 4, 1),
		(9, 'Hyndburners', 1, 5, 5, 1),
		(10, 'The Lions', 3, 19, 5, 2),
		(11, 'KSB A', 2, 7, 6, 1),
		(12, 'Hyndburn TTC B', 2, 2, 5, 2),
		(13, 'Old Masters', 2, 13, 5, 2),
		(15, 'HSC', 3, 15, 5, 2),
		(16, 'Brierfield', 4, 3, 8, 1),
		(17, 'Mavericks', 1, 14, 5, 2),
		(18, 'KSB B', 3, 11, 6, 2),
		(19, 'Whalley Eagles', 3, 10, 7, 2),
		(20, 'KSB C', 3, 12, 6, 2),
		(21, 'KSB D', 3, NULL, 6, 3),
		(22, 'Whalley Hawks', 3, 16, 7, 2),
		(23, 'Hyndburn TTC D ', 3, NULL, 5, 4),
		(24, 'Hyndburn TTC C', 3, NULL, 5, 3),
		(25, 'Tackyfire', 1, NULL, 5, 3),
		(26, 'Whalley Kestrels', 3, NULL, 7, 3),
		(27, 'Adpak Aces', 1, NULL, 9, 3),
		(28, 'Doals Marauders', 1, NULL, 10, 4),
		(29, 'The Misfits', 1, NULL, 5, 4),
		(30, 'Slayers', 3, NULL, 5, 3),
		(31, 'Rolling Doals', 1, NULL, 10, 3),
		(33, 'Doals Jetstream', 1, NULL, 10, 4),
		(34, 'Hyndburn TTC E', 3, NULL, 5, 3),
		(35, 'Whalley Falcons', 3, NULL, 7, 3),
		(36, 'KSB E', 1, NULL, 6, 4),
		(37, 'KSB F', 1, NULL, 6, 4),
		(38, 'Whalley Phoenix', 3, NULL, 7, 4),
		(39, 'Doals Vikings', 1, NULL, 10, 4),
		(40, 'Hyndburn TTC F ', 3, NULL, 5, 4),
		(41, 'Ramsbottom C', 2, 17, 5, 2),
		(42, 'Ramsbottom D', 3, NULL, 5, 3),
		(43, 'Whalley Merlins', 3, NULL, 7, 4);
	");	
	
	$database->dbh->query("
		INSERT INTO `tt_player` (`id`, `first_name`, `last_name`, `rank`, `team_id`) VALUES
		(1, 'Martin', 'Wyatt', 2512, 4),
		(2, 'Keith', 'Lee', 2361, 4),
		(3, 'Andrea', 'Harrison', 2308, 4),
		(4, 'Matt', 'Harrison', 2209, 4),
		(199, 'Cliff', 'Dale', 1869, 12),
		(7, 'Dave', 'Kay', 2361, 4),
		(10, 'Colin', 'Parkinson', 2309, 8),
		(11, 'Matt', 'Nettleton', 2322, 8),
		(12, 'Ashley', 'Bradburn', 2273, 8),
		(13, 'Noel', 'Duffy', 2158, 8),
		(14, 'Ian', 'Haworth', 2150, 8),
		(15, 'Liam', 'Bedford', 2307, 8),
		(16, 'Michael', 'Moir', 2704, 2),
		(19, 'Ben', 'Farrarr', 1526, 2),
		(20, 'Dean', 'Walmersley', 2361, 2),
		(21, 'Graham', 'Young', 2338, 2),
		(24, 'Duncan', 'Rigby', 2120, 9),
		(25, 'Fred', 'Wade', 1886, 9),
		(26, 'Dan', 'Chamberlain', 1789, 9),
		(27, 'Dave', 'Southern', 1960, 9),
		(31, 'Mandy', 'Winskill', 2173, 5),
		(33, 'Graham', 'Hoy', 2305, 5),
		(35, 'Tommy', 'Ryan', 2234, 6),
		(36, 'Martin', 'Holt', 2246, 6),
		(37, 'Neil', 'Booth', 2227, 6),
		(38, 'Les', 'Phillipson', 2240, 6),
		(40, 'Damon', 'Blezard', 2196, 7),
		(41, 'Adam', 'Blezard', 2133, 7),
		(42, 'Ian', 'Mason', 1812, 7),
		(44, 'Ian', 'Mitchell', 1881, 10),
		(45, 'Martin', 'Ormsby', 1821, 10),
		(46, 'Chris', 'Walton', 1718, 10),
		(47, 'John', 'Kopec', 1585, 10),
		(48, 'Keith', 'Ward', 2350, 3),
		(49, 'Keith', 'Jackson', 2335, 3),
		(50, 'Ged', 'Simpson', 1978, 3),
		(51, 'Jack', 'Keogh', 2121, 16),
		(52, 'Matt', 'Hirst', 2135, 11),
		(53, 'Daven', 'Argile', 1933, 11),
		(54, 'Matt', 'Hodgkinson', 2052, 11),
		(55, 'Fred', 'Coghlan', 2016, 15),
		(56, 'David', 'Eastwood', 1891, 16),
		(57, 'David', 'Allen', 1913, 41),
		(58, 'Barry', 'Hall', 2001, 13),
		(59, 'John', 'Thornber', 1907, 13),
		(60, 'Doug', 'Argile', 1835, 11),
		(61, 'Ian', 'Beecroft', 1892, 17),
		(62, 'Graham', 'Burns', 1772, 15),
		(63, 'Bob', 'Birch', 1742, 1),
		(64, 'Alan', 'Prudden', 1852, 17),
		(65, 'Ray', 'Kay', 1950, 9),
		(66, 'Trevor', 'Elkington', 1871, 18),
		(67, 'Tim', 'Fields', 1703, 41),
		(68, 'Mike', 'Turner', 1693, 19),
		(69, 'Scott', 'Thompson', 1714, 1),
		(71, 'Derek', 'Edwards', 1447, 42),
		(73, 'Kieran', 'Cunliffe', 1358, 22),
		(74, 'John', 'Burgoyne', 1705, 17),
		(75, 'Roger', 'Whewell', 1764, 13),
		(77, 'Peter', 'Howard', 1691, 16),
		(78, 'Phil', 'Hutchinson', 895, 1),
		(79, 'Frank', 'Hamer', 1735, 15),
		(80, 'Ian', 'Pickles', 1730, 13),
		(81, 'Peter', 'Marsland', 1594, 16),
		(82, 'John', 'Collins', 1897, 18),
		(84, 'David', 'Borland', 1782, 19),
		(85, 'Alan', 'Calow', 1778, 19),
		(86, 'Craig', 'Milnes', 1604, 18),
		(87, 'Paul', 'Wood', 1673, 41),
		(88, 'Phil', 'Mileham', 1853, 19),
		(90, 'Graham', 'Meloy', 1445, 17),
		(91, 'Grant', 'Saggers', 1247, 20),
		(92, 'Alan', 'Duckworth', 1290, 15),
		(93, 'Derek', 'Parkinson', 1443, 16),
		(94, 'Simon', 'Kavanagh', 1060, 21),
		(96, 'Albert', 'Pickles', 1761, 13),
		(98, 'Mark', 'Gleave', 1928, 15),
		(99, 'Simon', 'Charnley', 2241, 12),
		(101, 'Stephen', 'Siddall', 1190, 42),
		(102, 'Neil', 'McKinnon', 1442, 20),
		(103, 'Elton', 'Atkins', 1357, 25),
		(104, 'Pak', 'Wan', 1173, 25),
		(106, 'Charlie', 'McGrath', 1440, 2),
		(107, 'Steve', 'Horner', 1576, 20),
		(108, 'Richard', 'Staines', 948, 24),
		(110, 'Adam', 'Robinson', 1426, 22),
		(111, 'Gerald', 'Laxton', 1353, 31),
		(112, 'Tim', 'Prior', 1071, 20),
		(114, 'Martin', 'Drury', 1388, 22),
		(115, 'Phillip', 'Grace', 1289, 26),
		(116, 'Chris', 'Booth', 1239, 25),
		(117, 'Barrie', 'Howarth', 994, 21),
		(120, 'Paul', 'McGovern', 1106, 27),
		(122, 'Matthew', 'Birch', 1082, 27),
		(123, 'Keith', 'Ainscoe', 1178, 29),
		(124, 'Chris', 'Leaves', 1063, 42),
		(125, 'Paul', 'Waddington', 1197, 30),
		(128, 'Harry', 'Rawcliffe', 979, 29),
		(129, 'John', 'Farrow', 1181, 27),
		(130, 'Alan', 'Ross', 870, 35),
		(131, 'Mike', 'Hindle', 1005, 30),
		(132, 'Peter', 'Booth', 1013, 30),
		(133, 'Mark', 'Read', 913, 29),
		(134, 'Anthony', 'Farrow', 886, 27),
		(135, 'Eddie', 'Pilling', 691, 29),
		(136, 'Duncan', 'Taylor', 675, 28),
		(137, 'Alven', 'Burrows', 742, 30),
		(139, 'Adam', 'Hek', 986, 25),
		(140, 'Dominic', 'Siddall', 475, 42),
		(143, 'Neil', 'Hepworth', 1306, 31),
		(144, 'Steve', 'Nightingale', 985, 26),
		(146, 'Carlton', 'Cooper', 1104, 36),
		(148, 'Ryan', 'Fallon', 826, 31),
		(149, 'Bob', 'Walker', 628, 33),
		(150, 'Ian', 'Mills', 647, 28),
		(151, 'Kim', 'Croydon', 703, 35),
		(152, 'Bernard', 'Milnes', 601, 37),
		(156, 'Eric', 'Ronnan', 656, 43),
		(157, 'Peter', 'Hepworth', 663, 31),
		(158, 'Jon', 'Andrews', 467, 39),
		(160, 'Hugh', 'Graham', 594, 35),
		(161, 'Warwick', 'Lewthwaite', 584, 43),
		(163, 'Matt', 'Calow', 440, 38),
		(164, 'Bob', 'Thompson', 368, 39),
		(165, 'Dominic', 'Walsh', 485, 28),
		(166, 'Ian', 'Glover', 413, 36),
		(169, 'Graham', 'Davie', 394, 38),
		(171, 'Zachary', 'Geldard', 493, 34),
		(172, 'Felicity', 'Pickard', 711, 24),
		(173, 'Reece', 'Monk', 459, 23),
		(174, 'Daniel', 'O''Sullivan', 315, 40),
		(175, 'John', 'Price', 331, 38),
		(176, 'Kean', 'Erwin', 318, 36),
		(178, 'Peter', 'Brzezicki', 218, 40),
		(181, 'Paul', 'Milnes', 266, 37),
		(182, 'Ryan', 'Monk', 323, 23),
		(183, 'Will', 'Cooper', 217, 36),
		(185, 'Sam', 'Hinchcliffe', 459, 34),
		(186, 'Harry', 'Walker', 156, 33),
		(187, 'Cory', 'Foster', 347, 23),
		(188, 'Dec', 'O''Kane', 469, 34),
		(189, 'Roger', 'Millham', 204, 40),
		(200, 'Nigel', 'Feuster', 1825, 12),
		(201, 'Ian', 'Lloyd', 1804, 12),
		(202, 'Dougie', 'Hill', 0, 12),
		(203, 'Mina', 'Makram', 0, 12),
		(204, 'David', 'Cain', 0, 12),
		(205, 'Frank', 'Gray', 1729, 17),
		(206, 'Catherine', 'Lawson', 1242, 25),
		(207, 'Malcolm', 'Pelham', 300, 23),
		(208, 'Thomas', 'Boden', 187, 40),
		(209, 'Thomas', 'Feuster', 200, 40),
		(210, 'Ian', 'Wheeldon', 1700, 41),
		(211, 'T', 'Warbuton', 400, 42),
		(212, 'Jordan', 'Brookes', 2025, 5),
		(213, 'Michael', 'Brierley', 2023, 5),
		(214, 'Alan', 'Auxilly', 2000, 5),
		(215, 'Terry', 'Taylor', 2000, 6),
		(216, 'Michael', 'Wrigley', 1683, 16),
		(217, 'Peter', 'Norcliffe', 623, 35),
		(218, 'Stuart', 'Cole', 1074, 21),
		(219, 'Sean', 'Kilgarriff', 500, 21),
		(220, 'Adam', 'Kemp', 679, 24),
		(221, 'Ross', 'Erwin', 914, 36),
		(222, 'Simon', 'Milnes', 291, 37),
		(223, 'Ben', 'Milnes', 300, 37),
		(224, 'David', 'Greenwood', 453, 39),
		(225, 'Stuart', 'Summer', 200, 39),
		(233, 'Thomas', 'Summer', 182, 33),
		(226, 'John', 'Walsh', 200, 39),
		(227, 'Roman', 'Mychajlshyn', 570, 28),
		(228, 'Luke', 'Waring', 400, 43),
		(229, 'Jorden', 'Barnowski', 344, 43),
		(230, 'Chris', 'Donald', 406, 38),
		(231, 'Phillip', 'Hutchinson', 696, 26),
		(232, 'K', 'Oldfield', 475, 42),
		(234, 'James', 'Croydon', 425, 38),
		(235, 'Dave', 'Evans', 290, 39),
		(236, 'Burhan', 'Khan', 422, 40),
		(237, 'Eli', 'Smith', 222, 40),
		(238, 'Francis', 'Kinsella', 314, 40),
		(239, 'Thomas', 'Feuster', 274, 40);
	");	

} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Test Data</h1>';
	echo $e;
	
}