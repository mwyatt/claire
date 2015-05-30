<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $metaTitle ?></title>   
    <meta name="keywords" content="<?php echo $metaKeywords ?>">
    <meta name="description" content="<?php echo $metaDescription ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">

<?php include $this->getTemplatePath('header/_css') ?>

    <script src="<?php echo $this->getUrlAsset('vendor/modernizr.js') ?>"></script>
    <script>var urlBase = '<?php echo $this->url->generate() ?>';</script>

<?php include $this->getTemplatePath('header/_google-analytics') ?>

</head>
<body<?php echo ($this->getBodyClass() ? ' class="' . $this->getBodyClass() . '"' : '') ?>>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site">
    <div class="header-page-container">
        <a href="#top" class="to-top js-smooth-scroll"><?php include $this->getAssetPath('arrow-up.svg') ?></a>
        <div class="header-container">
            <div class="profile-container">
                <div class="profile-image-container">
                    <img src="<?php echo $this->getUrlAsset('portrait-138.jpg') ?>" alt="Claire Ruths portrait" class="profile-img">
                </div>
                <p class="portrait-description">Claire is a good person.</p>
            </div>
            <div class="logo-container">

<?php include $this->getTemplatePath('_logo') ?>
                
            </div>
            <div class="header-menu-primary-container">
                
<?php include $this->getTemplatePath('_menu-primary') ?>

            </div>
            <div class="header-socials-container">
                <div class="header-social">
                    <div class="header-social-icon"><?php include $this->getAssetPath('pinterest.svg') ?></div>
                    <h6 class="header-social-title">Pinterest</h6>
                </div>
            </div>
        </div>
