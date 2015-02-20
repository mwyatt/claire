<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js <?php echo isset($templateName) ? 'template-' . $templateName : '' ?>"> <!--<![endif]-->
<head>

<?php include($this->getTemplatePath('header/_meta')) ?>
<?php include($this->getTemplatePath('header/_common')) ?>

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    
<?php include($this->getTemplatePath('header/_google-analytics')) ?>

</head>
<body<?php echo ($this->getBodyClass() ? ' class="' . $this->getBodyClass() . '"' : '') ?>>

    <!--[if lt IE 9]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

<div id="top"></div>
<div class="container container-site <?php echo ! empty($year) ? 'is-archive' : '' ?>">
    <div class="container-site-inner">
        <a href="#top" class="to-top js-smooth-scroll"><img class="to-top-image" src="<?php echo $this->getAssetPath('arrow-up.svg') ?>" onerror="this.src=''; this.onerror=null;"></a>
        <header class="container-header row js-container-header clearfix js-fixed-bar">
            <div class="container-header-inner">

        <?php include($this->getTemplatePath('header/_logo')) ?>

                <a href="mailto:martin.wyatt@gmail.com" class="header-sticker-beta" title="<?php echo $option['site_title']->getValue() ?> is still actively under development. If you notice any bugs or have any improvements please email me: martin.wyatt@gmail.com">Beta</a>

        <?php $menu = $menuPrimary; ?>
        <?php include($this->getTemplatePath('_menu-primary')) ?>
        <?php include($this->getTemplatePath('_menu-division')) ?>
        <?php include $this->getTemplatePath('header/_year') ?>

            </div>
        </header>
