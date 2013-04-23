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
    <body>
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

       	<div class="wrap">
    		<div class="content login clearfix">
    			<a class="logo" href="<?php echo $this->urlHome(); ?>" title="Open Homepage"><span>4</span></a>
    			<form method="post" name="form_login">
    				<input type="hidden" name="form_login" value="true">

<?php echo $this->getFeedback(); ?>

                    <div class="row">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" type="text" name="email_address" autofocus="autofocus"<?php echo ($this->session->get('form_field', 'email') ? ' value="' . $this->session->getUnset('form_field', 'email') . '"' : ''); ?>>
                    </div>
                    <div class="row">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password">
                    </div>
                    <input type="submit">
                    <a href="#" class="submit button">Login</a>
                </form>
    		</div>
            <script src="<?php echo $this->urlHome(); ?>js/vendor/jquery-1.8.2.min.js"></script>
            <script src="<?php echo $this->urlHome(); ?>js/admin/main.js"></script>
    	</div>
    </body>
</html>