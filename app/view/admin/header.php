<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $this->getMeta('title'); ?></title>	
		<meta name="keywords" content="<?php echo $this->getMeta('keywords'); ?>">
        <meta name="description" content="<?php echo $this->getMeta('description'); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $this->urlHome(); ?>css/admin/main.less">
        <script src="<?php echo $this->urlHome(); ?>js/vendor/less-1.3.3.min.js"></script>
        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr.custom.73218.js"></script>
    </head>
    <body>
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

   	<div class="wrap">

		<header class="main">

		    <div class="title">
		    	
		    	<div><img src="" alt="" width="16" height="16"></div>

		    	<a href="<?php echo $this->urlHome(); ?>" target="_blank" title="Open Homepage"><?php echo $this->get('model_mainoption', 'site_title'); ?></a>

		    </div>
		    
			<div class="user">

				<a href="#" class="name"><?php echo $modelMainuser->get('first_name'); ?></a>

				<ul>
					<li><a href="<?php echo $this->urlHome(); ?>admin/user/">Profile</a></li>
					<li><a href="?logout=true">Logout</a></li>
				</ul>

			</div>

			<div class="clearfix"></div>

			<!-- feedback -->

			<?php echo $this->getFeedback(); ?>

			<!-- main -->

			<nav class="main"><?php echo $modelMainmenu->admin(); ?></nav>

			<!-- sub -->

			<?php echo $modelMainmenu->adminSub(); ?>

		</header>