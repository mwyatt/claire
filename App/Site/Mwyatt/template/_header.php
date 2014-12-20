<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js <?php echo isset($templateName) ? 'template-' . $templateName : '' ?>"> <!--<![endif]-->
<head>

<?php include($this->getTemplatePath('header/_meta')) ?>

    <link rel="icon" type="image/png" href="<?php echo $this->getUrlMedia('favicon.png') ?>?rev=1">
    <script>var urlBase = '<?php echo $this->getUrl() ?>';</script>
    <link href="<?php echo $this->getUrlAsset('screen.css') ?>" media="screen, projection, print" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    
<?php include($this->getTemplatePath('header/_google-analytics')) ?>

    <script src="<?php echo $this->getUrlAsset('vendor/modernizr.js') ?>"></script>
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<a class="to-top">Scroll to top</a>
<div class="site-wrap">
    <div class="header-bar-height"></div>
    <header class="header header-bar js-header">

	    <!-- logo -->
	    <a href="<?php echo $this->getUrl() ?>" class="header-logo">
			<img class="header-logo-image" src="<?php echo $this->getUrlAsset('logo.svg') ?>" onerror="this.src=''; this.onerror=null;">
	    </a>

        <!-- hamburger - yum! -->
        <span class="menu-hamburger js-toggle-menu-primary"><span class="menu-hamburger-meat"></span></span>

<?php if (isset($menuPrimary)): ?>

        <nav class="menu-primary js-menu-primary">

        	<?php echo $menuPrimary ?>

        </nav>

<?php endif ?>

    </header>
