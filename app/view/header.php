<?php require_once('doctype.php'); ?>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
<head>

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
	?>

	<!-- Basic Page Title and Metas
	================================================== -->	
	<meta charset="utf-8">
	
	<title><?php echo $options->get('site_title'); ?></title>	
	
	<meta name="description" content="<?php echo $options->get('site_description'); ?>">
	<meta name="keywords" content="<?php echo $options->get('site_keywords'); ?>">
	
	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/skeleton.css'); ?>">
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/layout.css'); ?>">
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/flexslider.css'); ?>">
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/base.css'); ?>">
	
	<!-- Fonts
	================================================== -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'> <!-- Book 300, Normal 400, Semi-Bold 600, Bold 700 -->
	
	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php echo $view->urlMedia('i/fav/favicon.ico'); ?>">
	<link rel="apple-touch-icon" href="<?php echo $view->urlMedia('i/fav/apple-touch-icon.png'); ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $view->urlMedia('i/fav/apple-touch-icon-72x72.png'); ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $view->urlMedia('i/fav/apple-touch-icon-114x114.png'); ?>">	
	
</head>
<body<?php echo $view->bodyClass(); ?>>

<div class="container">

	<header class="base">
	
		<div class="sixteen columns">
			<form id="search" class="hide">
				<input type="text" name="search" placeholder="You never know." spellcheck="false">
			</form>			
			<div class="btn search"></div>
		</div>		
			
		<div class="four columns">
		
			<?php $view->logoMvc(); ?>
			
		</div>
		
		<div class="twelve columns">
						
			<?php //echo $menu->create('main'); ?>
			
		</div>
		
		<div class="clearfix"></div>
		
	</header>