<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $mainOption->get('site_title'); ?></title>	
        <meta name="description" content="<?php echo $mainOption->get('site_description'); ?>">
		<meta name="keywords" content="<?php echo $mainOption->get('site_keywords'); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- css -->

        <link rel="stylesheet" href="<?php echo $this->urlHome(); ?>css/vendor/normalize.css">
        <link rel="stylesheet" href="<?php echo $this->urlHome(); ?>css/main.css">

        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr-2.6.2.min.js"></script>

    </head>
    <body>
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

    <header class="main">

        <a href="#" class="logo"><img src="<?php echo $this->urlHome(); ?>img/main/logo.png" alt=""></a>

        <form>
            <input type="text" name="search" type="search" maxlength="999" placeholder="Search">
            <ul></ul>
        </form> 
        
    </header>
