<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $this->getMeta('title') ?></title>   
    <meta name="keywords" content="<?php echo $this->getMeta('keywords') ?>">
    <meta name="description" content="<?php echo $this->getMeta('description') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo $this->getUrl() ?>asset/screen.css?v=1" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
<script src="<?php echo $this->getUrlJs('exclude.modernizr.js?v=1') ?>"></script>
</head>
<body<?php echo ($this->getBodyClass() ? ' class="' . $this->getBodyClass() . '"' : '') ?> data-url-base="<?php echo $this->getUrl() ?>">
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site">
    <a href="#top" class="to-top js-smooth-scroll"><img class="to-top-image" src="<?php echo $this->getUrlMedia('arrow-up.svg') ?>" onerror="this.src=''; this.onerror=null;"></a>
    <header class="container-header row js-container-header clearfix js-fixed-bar">
        <div class="container-header-inner">
    
    <?php include($this->pathView('_logo')) ?>

    <!--             <a href="<?php echo $this->getUrl() ?>page/about-me/" class="propos">
                    <span class="propos-lettering">á propos de moi</span>
                    <span class="propos-flower"><img src="<?php echo $this->getUrl() ?>media/sprite/flower.png" alt="Flower"></span>
                </a> 

                <a href="#" class="button tertiary header-button-history">l'histoire complète</a>
            -->


            <a href="#menu" class="js-smooth-scroll header-button-mobile header-button-mobile-menu js-header-button-mobile-menu"><img class="header-button-mobile-image" src="<?php echo $this->getUrlMedia('menu.svg') ?>" onerror="this.src=''; this.onerror=null;"></a>
            <a href="#search" class="js-smooth-scroll header-button-mobile header-button-mobile-search js-header-button-mobile-search"><img class="header-button-mobile-image" src="<?php echo $this->getUrlMedia('search.svg') ?>" onerror="this.src=''; this.onerror=null;"></a>

    <?php $menu = array_reverse($mainMenu); ?>
    <?php include($this->pathView('_menu')) ?>
    <?php include($this->pathView('_search')) ?>

        </div>
    </header>
