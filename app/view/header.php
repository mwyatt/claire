<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" data-url-base="<?php echo $this->urlHome(); ?>"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $mainOption->get('site_title'); ?></title>	
        <meta name="description" content="<?php echo $mainOption->get('site_description'); ?>">
		<meta name="keywords" content="<?php echo $mainOption->get('site_keywords'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="<?php echo $this->urlHome(); ?>css/vendor/normalize.css">
        <!-- <link rel="stylesheet" href="<?php echo $this->urlHome(); ?>css/main.css"> -->
        <link rel="stylesheet/less" type="text/css" href="<?php echo $this->urlHome(); ?>css/main.less" />
        <script src="<?php echo $this->urlHome(); ?>js/vendor/less-1.3.3.min.js"></script>
        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

    <header class="main">
        <a class="logo" href="<?php echo $this->urlHome(); ?>">4</a>
        <div class="button menu">
            <span>2</span>
            <nav>
                <div><a href="<?php echo $this->urlHome(); ?>">Home</a></div>
                <div>
                    <a href="<?php echo $this->urlHome(); ?>">The League <span>3</span></a>
                    <div>
                        <div><a href="#">Handbook</a></div>
                        <div><a href="#">Handbook</a></div>
                        <div><a href="#">Handbook</a></div>
                    </div>
                </div>
                <div><a href="<?php echo $this->urlHome(); ?>post/">Press Releases</a></div>
                <div><a href="#">Contact us</a></div>
            </nav>
        </div>
        <div class="button results">
            <span>9</span>
            <?php echo $mainMenu->buildDivision(); ?>
        </div>
        <div class="button search">
            <span>1</span>
            <form>
                <input type="text" name="search" type="search" maxlength="999" placeholder="Search">
                <section></section>
            </form> 
        </div>
        <div class="clearfix"></div>
    </header>
