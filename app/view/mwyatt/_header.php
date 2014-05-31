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
    <!-- // <script src="<?php echo $this->getUrl() ?>js/vendor/respond.min.js"></script> -->
    <script src="<?php echo $this->getUrl() ?>js/exclude/modernizr.js"></script>
</head>
<body<?php echo ($this->getBodyClass() ? ' class="' . $this->getBodyClass() . '"' : '') ?> data-url-base="<?php echo $this->getUrl() ?>">
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="site-wrap">
    <header class="container-header js-container-header">
        <a href="#my-menu" class="js-smooth-scroll header-button-mobile header-button-mobile-menu js-header-button-mobile-menu"><?php include($this->getPathMedia('menu.svg')) ?></a>
        <a href="echo" class="logo">
            
<?php include($this->getPathMedia('logo.rev1.svg')) ?>
            
        </a>
        <nav id="my-menu">
           <ul>
              <li><a href="/">Home</a></li>
              <li>
                <a href="/about/">About us</a>
                  <ul>
                      <li><a href="/about/history/">History</a></li>
                      <li><a href="/about/team/">The team</a></li>
                      <li><a href="/about/address/">Our address</a></li>
                   </ul>
               </li>
              <li><a href="/contact/">Contact</a></li>
           </ul>
        </nav>

        <?php $menu = $mainMenu; ?>
        <?php //include($this->pathView('_menu')) ?>

    </header>
