<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js <?php echo isset($templateName) ? 'template-' . $templateName : '' ?>"> <!--<![endif]-->
<head>

<?php include($this->getPathTemplate('header/_meta')) ?>
<?php include($this->getPathTemplate('header/_css')) ?>

    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="<?php echo $url->generate() ?>asset/favicon.png">

<?php include($this->getPathTemplate('header/_google-analytics')) ?>

</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site">
    <div class="header-page-container">
        <a href="#top" class="to-top js-smooth-scroll"><?php include $this->getPathBase('asset/arrow-up.svg') ?></a>
        <div class="header-container">
            <div class="profile-container">
                <div class="profile-image-container">
                    <img src="<?php echo $url->generate() ?>asset/portrait-138.jpg" alt="Claire Ruths portrait" class="profile-img">
                </div>
                <p class="portrait-description">Language and literature enthusiast based in the North West of England.</p>
            </div>
            <div class="logo-container">

<?php include $this->getPathTemplate('_logo') ?>
                
            </div>
            <div class="header-menu-primary-container">
                
<?php include $this->getPathTemplate('_menu') ?>

            </div>
            <div class="header-socials-container">
                <a href="http://www.pinterest.com/clmruth26/" class="header-social">
                    <span class="header-social-icon"><?php include $this->getPathBase('asset/pinterest.svg') ?></span>
                    <span class="header-social-title">Pinterest</span>
                </a>
            </div>
        </div>
