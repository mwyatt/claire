<?php

try {	

	// user
	$user->insert(10);
	echo '<br>' . 'Data \'user\' Inserted' . '<br>';
	
	// user_meta
	$database->dbh->query("
		INSERT INTO user_meta
			(user_id, name, value)
		VALUES
			('1', 'first_name', 'Steve')
			, ('1', 'last_name', 'Smith')
	");	
	echo  'Data \'user_meta\' Inserted' . '<br>';
	
	// content
	$database->dbh->query("
		INSERT INTO content
			(title, title_slug, html, type, guid, status, user_id)
		VALUES
			('Example Post Title 1', 'example_post_title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'post', 'http://localhost/posts/1/example-post-title-1/', 'visible', '1')
			, ('Example Post Title 2', 'example_post_title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'post', 'http://localhost/posts/2/example-post-title-2/', 'visible', '1')
			, ('Example Project Title 1', 'example-project-title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'project', 'http://localhost/projects/3/example-project-title-1/', 'visible', '1')
			, ('Example Project Title 2', 'example-project-title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'project', 'http://localhost/projects/4/example-project-title-2/', 'visible', '1')
			, ('Contact me', 'contact-me', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'page', 'http://localhost/mvc/contact-me/', 'visible', '1')
	");
	echo 'Data \'content\' Inserted' . '<br>';

	
	// content_meta
	$database->dbh->query("
		INSERT INTO content_meta
			(content_id, name, value)
		VALUES
			('1', 'colour', 'Red')
			, ('1', 'price', '200')
			, ('1', 'attached', '1, 3, 2')
			, ('1', 'tags', 'Photoshop, HTML, ')
	");	
	echo 'Data \'content_meta\' Inserted' . '<br>';

	
	// options
	$database->dbh->query("
		INSERT INTO options
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
	echo 'Data \'options\' Inserted' . '<br>';

	
	// media_tree
	$database->dbh->query("
		INSERT INTO media_tree
			(title, title_slug, parent_id)
		VALUES
			('Root', 'root', '')
			, ('Artwork', 'artwork', '1')
				, ('Cover', 'cover', '2')
			, ('Product', 'product', '1')
			, ('Temp', 'temp', '1')
	");	
	echo 'Data \'media_tree\' Inserted' . '<br>';

			
	// media
	$database->dbh->query("
		INSERT INTO media
			(title, title_slug, description, type, media_tree_id)
		VALUES
			('Example Media 1', '600x400', 'This Description should be very Descriptive for Search Engine Optimisation', 'gif', '1')
			, ('Example Media 2', 'example-media-2', 'This Description should be very Descriptive for Search Engine Optimisation', 'jpg', '1')
	");
	echo 'Data \'media\' Inserted' . '<br>';
	
	
	// ads
	$database->dbh->query("
		INSERT INTO ads
			(title, html, target, type, status, position, media_id)
		VALUES
			('Example Advertisement 1', '<p>Example HTML Code</p>', 'http://localhost/mvc/example-link/', 'cover', 'visible', '1', '1')
			, ('Example Advertisement 2', '<p>Example HTML Code</p>', 'http://localhost/mvc/example-link/', 'cover', 'visible', '1', '1')
	");
	echo 'Data \'ads\' Inserted' . '<br>';	
	
	
	// content_media
	$database->dbh->query("
		INSERT INTO content_media
			(content_id, media_id, position)
		VALUES
			('1', '1', '2')
			, ('1', '2', '1')
	");	
	echo 'Data \'content_media\' Inserted' . '<br>';	


	// menu
	$database->dbh->query("
		INSERT INTO menu
			(type, title, guid, parent_id, position)
		VALUES
			('main', 'Home', 'http://localhost/mvc/', '0', '1')
			, ('main', 'Posts', 'http://localhost/mvc/posts/', '0' '2')
			, ('main', 'Contact', 'http://localhost/mvc/contact-me/', '0' '3')
	");	
	echo 'Data \'menu\' Inserted' . '<br>';


} catch (PDOException $e) { 

	// Handle Exception
	echo '<h1>Exception while Installing Test Data</h1>';
	echo $e;
	
}