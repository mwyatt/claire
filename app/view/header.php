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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $this->urlHome(); ?>css/main.less">
        <script src="<?php echo $this->urlHome(); ?>js/vendor/less-1.3.3.min.js"></script>
        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr.custom.73218.js"></script>
    </head>
    <body data-url-base="<?php echo $this->urlHome(); ?>">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="wrap">
            <header class="main">
                <div class="row clearfix">
                    <a href="<?php echo $this->urlHome() ?>page/contact-us/" class="button contact-us right hide">Contact us</a>
                    <a class="logo" href="<?php echo $this->urlHome(); ?>">
                        <img src="<?php echo $this->urlHome(); ?>media/logov2.png" alt="<?php echo $this->get('options', 'site_title'); ?> Logo">
                        <span class="full-text"><?php echo $this->get('options', 'site_title'); ?></span>
                        <abbr title="<?php echo $this->get('options', 'site_title'); ?>">ELTTL</abbr>
                    </a>
                    <div class="search">
                        <form class="main" method="get">
                            <label for="form-search">Search</label>
                            <span class="close"></span>
                            <input id="form-search" type="text" name="search" type="search" maxlength="75">
                            <a href="#" class="submit button">Search</a>
                            <input type="submit">
                        </form> 
                    </div>
                    <nav class="sub">
                        <label>Menu</label>
                        <div class="inner">
                            <span class="close"></span>
                            <a href="<?php echo $this->urlHome(); ?>page/coaching/">Coaching</a>
                            <a href="<?php echo $this->urlHome(); ?>page/schools/">Schools</a>
                            <a href="<?php echo $this->urlHome(); ?>page/town-teams/">Town Teams</a>
                            <a href="<?php echo $this->urlHome(); ?>page/summer-league/">Summer League</a>
                            <a href="<?php echo $this->urlHome(); ?>page/local-clubs/">Local Clubs</a>
                        </div>
                    </nav> 
                </div>
                <nav class="main clearfix">
                    <ul>
                        <li>
                            <a href="<?php echo $this->urlHome(); ?>">Home</a>
                        </li>
                        <li>
                            <a href="#">Tables and Results</a>

<?php if ($this->get('model_mainmenu', 'division')): ?>
    
                            <div class="drop">

    <?php foreach ($this->get('model_mainmenu', 'division') as $division): ?>

                                <div class="division-<?php echo strtolower($this->get($division, 'name')) ?>">
                                    <h4><a href="<?php echo $this->get($division, 'guid') ?>"><?php echo $this->get($division, 'name') ?></a></h4>
                                    <a href="<?php echo $this->get($division, 'guid') ?>">Overview</a>
                                    <a href="<?php echo $this->get($division, 'guid') ?>merit/">Merit Table</a>
                                    <a href="<?php echo $this->get($division, 'guid') ?>league/">League Table</a>
                                    <a href="<?php echo $this->get($division, 'guid') ?>fixture/">Fixtures</a>
                                </div>        
        
    <?php endforeach ?>

                            </div>

<?php endif ?>   

                        </li>
                        <li>
                            <a href="">The League</a>
                            <div class="drop">
                                <a href="#">Handbook</a>
                                <a href="<?php echo $this->urlHome(); ?>player/performance/">Player Performance</a>
                                <a href="<?php echo $this->urlHome(); ?>press/">Press Releases</a>
                                <a href="<?php echo $this->urlHome(); ?>page/competitions/">Competitions</a>
                                <a href="<?php echo $this->urlHome(); ?>page/contact-us/">Contact us</a>
                            </div>
                        </li>
                    </ul>
                </nav>             
            </header>
