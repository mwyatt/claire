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
    <script src="<?php echo $this->getUrlJs('modernizr.js?v=1') ?>"></script>
    <script>var urlBase = '<?php echo $this->getUrl() ?>';</script>
</head>
<body<?php echo ($this->getBodyClass() ? ' class="' . $this->getBodyClass() . '"' : '') ?>>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site">
    <div class="container-site-inner">
        <a href="#top" class="to-top js-smooth-scroll"><img class="to-top-image" src="<?php echo $this->getUrlMedia('arrow-up.svg') ?>" onerror="this.src=''; this.onerror=null;"></a>
        <header class="container-header row js-container-header clearfix js-fixed-bar">
            <div class="container-header-inner">
                <a href="" class="header-logo">
                    <span class="header-logo-emblem"><img class="header-logo-emblem-image" src="<?php echo $this->getUrlMedia('logo-emblem.svg') ?>" onerror="this.src=''; this.onerror=null;"></span>
                    <span class="header-logo-text-full">East Lancashire Table Tennis League</span>
                    <span class="header-logo-text-short">ELTTL</span>
                </a>

        <?php $menu = $menuSecondary; ?>
        <?php include($this->pathView('_menu-secondary')) ?>

        <?php $menu = $menuPrimary; ?>
        <?php include($this->pathView('_menu-primary')) ?>

            </div>
        </header>