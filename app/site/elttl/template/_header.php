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
    <link rel="icon" type="image/png" href="<?php echo $this->getUrlMedia('favicon.png') ?>?rev=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo $this->getUrlAsset('asset/screen.css') ?>" media="screen, projection, print" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    <script src="<?php echo $this->getUrlAsset('vendor/bower/modernizr/modernizr.js') ?>"></script>
    <script>var urlBase = '<?php echo $this->getUrl() ?>';</script>
    
<?php include($this->getTemplatePath('header/_google-analytics')) ?>

</head>
<body<?php echo ($this->getBodyClass() ? ' class="' . $this->getBodyClass() . '"' : '') ?>>

    <!--[if lt IE 9]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site <?php echo ! empty($year) ? 'is-archive' : '' ?>">
    <div class="container-site-inner">
        <a href="#top" class="to-top js-smooth-scroll"><img class="to-top-image" src="<?php echo $this->getUrlMedia('arrow-up.svg') ?>" onerror="this.src=''; this.onerror=null;"></a>
        <header class="container-header row js-container-header clearfix js-fixed-bar">
            <div class="container-header-inner">

        <?php include($this->getTemplatePath('header/_logo')) ?>

                <a href="mailto:martin.wyatt@gmail.com" class="header-sticker-beta" title="<?php echo $option['site_title'] ?> is still actively under development. If you notice any bugs or have any improvements please email me: martin.wyatt@gmail.com">Beta</a>

        <?php $menu = $menuPrimary; ?>
        <?php include($this->getTemplatePath('_menu-primary')) ?>
        <?php include($this->getTemplatePath('_menu-division')) ?>
        <?php include $this->getTemplatePath('header/_year') ?>

            </div>
        </header>
