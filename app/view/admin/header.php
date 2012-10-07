<!doctype html>
<html>
<head>
	
	
	<!-- Basic Page Title and Metas
	======================================================================== -->

	<meta charset="utf-8">
	<title><?php echo $options->get('site_title'); ?></title>	
	<meta name="description" content="<?php echo $options->get('site_description'); ?>">
	<meta name="keywords" content="<?php echo $options->get('site_keywords'); ?>">
	
	
	<!-- Mobile Specific Metas
	======================================================================== -->

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	
	<!-- CSS
	======================================================================== -->

	<link rel="stylesheet" href="<?php echo $this->urlHome(); ?>asset/style/skeleton.css">
	<link rel="stylesheet" href="<?php echo $this->urlHome(); ?>asset/style/layout.css">
	<link rel="stylesheet" href="<?php echo $this->urlHome(); ?>asset/style/admin-base.css">
	
	
	<!-- Favicons
	======================================================================== -->

	<link rel="shortcut icon" href="<?php echo $this->urlHome(); ?>media/i/fav/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo $this->urlHome(); ?>media/i/fav/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->urlHome(); ?>media/i/fav/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->urlHome(); ?>vi/fav/apple-touch-icon-114x114.png">	

</head>
<body>

<div class="line-bottom">
	<div class="container">
		
		<header class="base">
		
			<div class="profile">
				<a style="background: url('<?php echo $this->urlHome(); ?>media/i/cc/16.gif') 0% 50% no-repeat;" href="<?php echo $this->urlHome(); ?>" target="_blank" title="Open Homepage"><?php echo $options->get('site_title'); ?></a>
			</div>
		
			<div class="user">
				<a class="name"><?php echo $user->get('first_name'); ?></a>
				<div class="drop">
					<ul>
						<li><a href="<?php echo $this->urlHome(); ?>cc/profile/">Profile</a></li>
						<li><a href="?logout=true">Example Longer Menu Item which may Exist</a></li>
						<li><a href="?logout=true">Logout</a></li>
					</ul>
				</div>
			</div>
			
			<div class="clearfix"></div>		
		
		</header>
		
	</div>
</div>

<div class="container">
	<nav class="base row">
		<?php echo $menu->adminBuild(); ?>
	</nav>
</div>
