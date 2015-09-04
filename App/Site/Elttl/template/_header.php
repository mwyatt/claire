<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>

<?php include($this->getTemplatePath('header/_meta')) ?>

    <link rel="icon" type="image/png" href="<?php echo $this->getUrlAsset('favicon.png') ?>">

<?php include $this->getTemplatePath('header/_css') ?>

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    <script>var urlBase = '<?php echo $this->url->generate() ?>';</script>
    <script src="<?php echo $this->getUrlAsset('vendor/modernizr.js') ?>"></script>
    
<?php include($this->getTemplatePath('header/_google-analytics')) ?>

</head>
<body>

    <!--[if lt IE 9]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site">
    <div class="container-site-inner">
        <a href="#top" class="to-top js-smooth-scroll"><span class="to-top-image"><?php include $this->getAssetPath('arrow-up.svg') ?></span></a>
        <header class="container-header row js-container-header clearfix js-fixed-bar">
            <div class="container-header-inner">

<?php include($this->getTemplatePath('header/_logo')) ?>

                <!-- <a href="mailto:martin.wyatt@gmail.com" class="header-sticker-beta" title="This website is still actively under development. If you notice any bugs or have any improvements please email me: martin.wyatt@gmail.com">Beta</a> -->

                    
<?php $menu = $menuPrimary; ?>
<?php include($this->getTemplatePath('_menu-primary')) ?>
<?php include($this->getTemplatePath('_menu-division')) ?>
<?php if (!empty($years)) : ?>
    
    <select name="year" class="header-select-year js-select-year dont-print" class="select-years">
    
    <?php foreach ($years as $yearUnique) : ?>
    
        <option value="<?php echo $yearUnique->name ?>" <?php echo empty($yearSingle) ? empty($year) ? '' : $year->id == $yearUnique->id ? 'selected' : '' : ($yearSingle->id == $yearUnique->id ? 'selected' : '') ?>>Season <strong><?php echo $yearUnique->getNameFull() ?></strong></option>

    <?php
endforeach ?>

    </select>

<?php endif ?>

<?php // include $this->getTemplatePath('header/_year') ?>

            </div>

<?php if (!empty($isArchive)) : ?>
    
            <!-- <div class="header-is-archive-container">You are inside an archive.</div> -->

<?php endif ?>

        </header>
        