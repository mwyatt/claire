<?php

try {
	
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
			(title, title_slug, html, type, guid, status, user_id)
		VALUES
			('Example Post Title 1', 'example_post_title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'post', 'http://localhost/posts/1/example-post-title-1/', 'visible', '1')
			, ('Example Post Title 2', 'example_post_title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'post', 'http://localhost/posts/2/example-post-title-2/', 'visible', '1')
			, ('Example Project Title 1', 'example-project-title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'project', 'http://localhost/projects/3/example-project-title-1/', 'visible', '1')
			, ('Example Project Title 2', 'example-project-title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'project', 'http://localhost/projects/4/example-project-title-2/', 'visible', '1')
			, ('Contact me', 'contact-me', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'page', 'http://localhost/mvc/contact-me/', 'visible', '1')
	");

	$database->dbh->query("
		INSERT INTO main_content_meta
			(content_id, name, value)
		VALUES
			('1', 'colour', 'Red')
			, ('1', 'price', '200')
			, ('1', 'attached', '1, 3, 2')
			, ('1', 'tags', 'Photoshop, HTML, ')
	");	

	$database->dbh->query("
		INSERT INTO main_option
			(name, value)
		VALUES
			('site_title', 'Martin Wyatt')			
			, ('site_keywords', 'Martin Wyatt, Portfolio, Blog, Notes, Web Design, Table Tennis')			
			, ('site_description', 'Martin Wyatts Blog and Portfolio')			
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

	$epochTime = time();

	$database->dbh->query("
		INSERT INTO main_media (
			file_name
			, title
			, title_slug
			, date_published
			, type
			, user_id
		)
		VALUES
			('grandma-and-family.jpg', 'Grandma and Family', 'example-media-1', $epochTime, 'jpg', '1')
			, ('minutes-081112.pdf', 'Minutes 002', 'minutes-002', $epochTime, 'pdf', '2')
	");

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
		INSERT INTO `tt_team` (`id`, `name`, `home_night`, `venue_id`, `division_id`) VALUES
		(1, 'Clitheroe LMC', 4, 3, 2),
		(2, 'Hyndburn TTC A', 3, 5, 1),
		(3, 'Ward & Stobbart', 1, 5, 1),
		(4, 'Burnley Boys Club', 1, 1, 1),
		(5, 'Ramsbottom A', 2, 2, 1),
		(6, 'Ramsbottom B', 2, 2, 1),
		(7, 'Rovers', 3, 5, 1),
		(8, 'East Lancs', 3, 4, 1),
		(9, 'Hyndburners', 1, 5, 1),
		(10, 'The Lions', 3, 5, 2),
		(11, 'KSB A', 2, 6, 1),
		(12, 'Hyndburn TTC B', 2, 5, 2),
		(13, 'Old Masters', 2, 5, 2),
		(15, 'HSC', 3, 5, 2),
		(16, 'Brierfield', 4, 8, 1),
		(17, 'Mavericks', 1, 5, 2),
		(18, 'KSB B', 3, 6, 2),
		(19, 'Whalley Eagles', 3, 7, 2),
		(20, 'KSB C', 3, 6, 2),
		(21, 'KSB D', 3, 6, 3),
		(22, 'Whalley Hawks', 3, 7, 2),
		(23, 'Hyndburn TTC D ', 3, 5, 4),
		(24, 'Hyndburn TTC C', 3, 5, 3),
		(25, 'Tackyfire', 1, 5, 3),
		(26, 'Whalley Kestrels', 3, 7, 3),
		(27, 'Adpak Aces', 1, 9, 3),
		(28, 'Doals Marauders', 1, 10, 4),
		(29, 'The Misfits', 1, 5, 4),
		(30, 'Slayers', 3, 5, 3),
		(31, 'Rolling Doals', 1, 10, 3),
		(33, 'Doals Jetstream', 1, 10, 4),
		(34, 'Hyndburn TTC E', 3, 5, 3),
		(35, 'Whalley Falcons', 3, 7, 3),
		(36, 'KSB E', 1, 6, 4),
		(37, 'KSB F', 1, 6, 4),
		(38, 'Whalley Phoenix', 3, 7, 4),
		(39, 'Doals Vikings', 1, 10, 4),
		(40, 'Hyndburn TTC F ', 3, 5, 4),
		(41, 'Ramsbottom C', 2, 5, 2),
		(42, 'Ramsbottom D', 3, 5, 3),
		(43, 'Whalley Merlins', 3, 7, 4)	
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