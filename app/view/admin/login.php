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

        <!-- css -->

        <link rel="stylesheet" href="<?php echo $this->urlHome(); ?>css/vendor/normalize.css">
        <link rel="stylesheet" href="<?php echo $this->urlHome(); ?>css/admin/main.css">

        <!-- modenizr -->

        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr-2.6.2.min.js"></script>

        <!-- favicon -->

        <link rel="icon" type="image/png" href="<?php echo $this->urlHome(); ?>img/main/favicon.png">

        <!-- font -->

        <link href="http://fonts.googleapis.com/css?family=Cabin:400,500,600,700" rel="stylesheet" type="text/css">
    </head>
    <body>
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

   	<div class="wrap">

		<div class="content login">


			<a class="logo" href="<?php echo $this->urlHome(); ?>" title="Open Homepage"><span>4</span></a>

			<form method="post">
				<input type="hidden" name="form_login" value="true">
                <?php echo $this->getFeedback(); ?>
                <div>
                    <input type="text" name="email_address" placeholder="Email Address" autofocus="autofocus"<?php echo ($this->getObject('session')->getUnset('form_field', 'email') ? ' value="' . $this->getObject('session')->getUnset('form_field', 'email') . '"' : ''); ?>>
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <input class="" type="submit" value="Login">
            </form>
				

		</div> <!-- .container -->

		<!-- js -->

        <script src="<?php echo $this->urlHome(); ?>js/vendor/jquery-1.8.2.min.js"></script>
        <script src="<?php echo $this->urlHome(); ?>js/admin/main.js"></script>

	</div> <!-- .wrap -->

    </body>
</html>