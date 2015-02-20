<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>

<?php require_once($this->getTemplatePath() . 'admin/header-resources.php') ?>

    </head>
    <body>
    	<!--[if lt IE 7]>
    	    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    	<![endif]-->

       	<div class="wrap">
    		<div class="content login clearfix">
    			<a class="logo" href="<?php echo $this->url->generate() ?>" title="Open Homepage"><span>4</span></a>
    			<form method="post" name="form_login">
                    <h1>Password recovery</h1>
    				<input type="hidden" name="form_login_recovery" value="true">

<?php echo $this->getFeedback() ?>

                    <div class="row">
                        <label for="email_address">Email Address</label>
                        <input id="email_address" type="text" name="email_address" autofocus="autofocus"<?php echo ($this->session->get('form_field', 'email') ? ' value="' . $this->session->getUnset('form_field', 'email') . '"' : '') ?>>
                    </div>
                    <div class="row">
                        <input type="submit">
                        <a href="#" class="submit button">Reset password</a>
                    </div>
                </form>
    		</div>
            <script src="<?php echo $this->url->generate() ?>js/vendor/jquery-1.8.2.min.js"></script>
            <script src="<?php echo $this->url->generate() ?>js/admin/main.js"></script>
    	</div>
    </body>
</html>