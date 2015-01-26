<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" data-module-name="<?php echo isset($moduleName) ? $moduleName : '' ?>"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $metaTitle ?></title>	
	<meta name="keywords" content="<?php echo $metaKeywords ?>">
	<meta name="description" content="<?php echo $metaDescription ?>">
	<meta name="viewport" content="width=device-width">
    <link href="<?php echo $this->getUrlAsset('admin/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <script type="text/javascript">var urlBase = '<?php echo $this->getUrl() ?>';</script>
</head>
<body>
	<!--[if lt IE 7]>
	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->

<div class="wrap">

<?php include $this->getTemplatePath('admin/_feedback-stream') ?>
<?php if (isset($adminUser)): ?>
	<?php include $this->getTemplatePath('admin/header/_menu') ?>
	
    <header class="main js-header-main">
    	<div class="header-inner">
	    	<div class="inner-title-nav-user">
		        <a class="header-site-title" href="<?php echo $this->getUrl() ?>" target="_blank" title="Open Homepage"><?php echo $metaTitle ?></a>

	<?php include $this->getTemplatePath('admin/header/_user') ?>
	<?php include $this->getTemplatePath('admin/header/_notify') ?>

			</div>
		</div>
	</header>

<?php endif ?>
