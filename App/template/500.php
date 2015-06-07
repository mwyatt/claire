<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Internal Server Error</title>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo $this->getUrlAsset('500.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <div class="page-container">
        <div class="page">
        	<div class="content-single">
        		<h1 class="page-primary-title">Internal Server Error</h1>
                <p class="p"><?php echo $exceptionMessage ?></p>
        		<p class="p">The server encountered an unexpected condition which prevented it from fulfilling the request. Please go <a class="a" href="<?php echo $this->url->generate('home') ?>">home</a>.</p>
        	</div>
        </div>
    </div>
</body>
</html>
