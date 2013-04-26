<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $this->getMeta('title'); ?></title>	
		<meta name="keywords" content="<?php echo $this->getMeta('keywords'); ?>">
        <meta name="description" content="<?php echo $this->getMeta('description'); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $this->urlHome(); ?>css/admin/main.less">
        <script src="<?php echo $this->urlHome(); ?>js/vendor/less-1.3.3.min.js"></script>
        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr.custom.73218.js"></script>
    </head>
    <body data-url-base="<?php echo $this->urlHome(); ?>">
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

   	<div class="wrap">
		<header class="main clearfix">
	    	<a class="title" href="<?php echo $this->urlHome(); ?>" target="_blank" title="Open Homepage"><?php echo $this->get('model_mainoption', 'site_title'); ?></a>
	    	
<?php if ($this->get('model_mainuser')): ?>

			<div class="user">
				<a href="#" class="name button"><?php echo ($this->get('model_mainuser', 'first_name') ? $this->get('model_mainuser', 'first_name') . ' ' . $this->get('model_mainuser', 'last_name') : $this->get('model_mainuser', 'email')); ?></a>
				<ul>
					<li><a href="<?php echo $this->urlHome(); ?>admin/user/">Profile</a></li>
					<li><a href="?logout=true">Logout</a></li>
				</ul>
			</div>

<?php endif ?>

<?php if ($this->get('model_mainmenu', 'admin')): ?>
    
    <nav class="main">
        <ul>

    <?php foreach ($this->get('model_mainmenu', 'admin') as $item): ?>

            <li><a class="button<?php echo ($this->get($item, 'current') ? ' current' : '') ?>" href="<?php echo $this->get($item, 'guid') ?>"><?php echo $this->get($item, 'name') ?></a></li>
        
    <?php endforeach ?>

        </ul>
    </nav>

<?php endif ?>
<?php if ($this->get('model_mainmenu', 'admin_sub')): ?>
    
    <nav class="sub">
        <ul>

    <?php foreach ($this->get('model_mainmenu', 'admin_sub') as $item): ?>

            <li><a class="<?php echo ($this->get($item, 'current') ? ' current' : '') ?>" href="<?php echo $this->get($item, 'guid') ?>"><?php echo $this->get($item, 'name') ?></a></li>
        
    <?php endforeach ?>

        </ul>
    </nav>

<?php endif ?>

<?php echo $this->getFeedback(); ?>

		</header>
