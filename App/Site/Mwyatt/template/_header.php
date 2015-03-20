<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js <?php echo isset($templateName) ? 'template-' . $templateName : '' ?>"> <!--<![endif]-->
<head>

<?php include($this->getTemplatePath('header/_meta')) ?>

    <link rel="icon" type="image/png" href="<?php echo $this->getAssetPath('favicon.png') ?>?rev=1">
    <script>var urlBase = '<?php echo $this->url->generate() ?>';</script>
    <link href="<?php echo $this->getUrlAsset('common.css') ?>" media="screen, projection, print" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    
<?php include($this->getTemplatePath('header/_google-analytics')) ?>

    <script src="<?php echo $this->getUrlAsset('vendor/modernizr.js') ?>"></script>
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <!-- 
         _   _  _ _ _ 
        | \_/ || | | |
        | \_/ || V V |
        |_| |_| \_n_/ 

        Welcome fellow developers!

     -->

<div id="top"></div>
<a href="#top" class="to-top js-smooth-scroll"><span class="to-top-image"><?php include $this->getAssetPath('arrow-up.svg') ?></span></a>
<div class="site-wrap">
    <header class="header header-bar js-header">
        <div class="header-logo-container">
    	    <a href="<?php echo $this->url->generate() ?>" class="header-logo"><?php include $this->getAssetPath('logo.svg') ?></a>
        </div>

<?php if (isset($menuPrimary)): ?>

        <div class="menu-primary-container">
            <nav class="menu-primary js-menu-primary">

	<?php echo $menuPrimary ?>

            </nav>
        </div>

<?php endif ?>

    </header>
    <div class="page-container">
