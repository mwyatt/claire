<!doctype html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
<head>

	<meta charset="utf-8">

	
	<!-- Page Title
	======================================================================== -->
	
	<title>Login to <?php echo $mainoption->get('site_title'); ?></title>	
		
		
	<!-- Meta
	======================================================================== -->
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="robots" content="noindex,nofollow">

	
	<!-- Styles
	======================================================================== -->
	
	<link rel="stylesheet" href="<?php echo $this->urlHome(); ?>asset/style/skeleton.css">
	<link rel="stylesheet" href="<?php echo $this->urlHome(); ?>asset/style/layout.css">
	<link rel="stylesheet" href="<?php echo $this->urlHome(); ?>asset/style/admin-base.css">
	
	<style type="text/css" media="all">
	
		#login {
			padding: 120px 0 0;
			margin: auto;
		}
		
		#login .logo {
			text-align: center;
			margin: 0 0 40px 0;
		}
			#login .logo a {
				margin: 0 auto;
			}
		
		#login form {
			text-align: center;
		}
		
			#login form input {
				margin: 0 20px 30px;
			}
		
			#login form input.error {
				border-color: red;
			}
		
	</style>	
	
</head>
<body>

<div class="container">

	<div id="login">

		<div class="logo"><a href="<?php echo $this->urlHome(); ?>" title="Open Homepage"><img src="<?php echo $this->urlHome(); ?>image/logo.png" alt="<?php echo $mainoption->get('site_title'); ?> Logo"></a></div>
		
		<div class="feedback"><p><?php echo $this->getFeedback(); ?></p></div>

		<form class="login" method="post">

			<input type="hidden" name="form_login" value="true">
			<div>
				<input type="text" name="username" placeholder="Username" autofocus="autofocus">					
			</div>
			<div>
				<input type="password" name="password" placeholder="Password">
			</div>
			<input class="" type="submit" value="Login">
			
		</form>

	</div> <!-- / #login -->

</div> <!-- / .container -->


<!-- Script
======================================================================== -->

<script src="<?php echo $this->urlHome(); ?>asset/script/vendor/jquery-1.8.0.min.js"></script>
<script src="<?php echo $this->urlHome(); ?>asset/script/vendor/modernizr-2.6.1.min.js"></script>

<script type="text/javascript">

	$("form.login").submit(function() {
		
		// Variable(s)
		var form = $("form.login");
		var fieldName;
		var field;
		var valid = true;
		
		// Function checkField
		function checkField(fieldName) {
		
			// Set Field
			field = $("input[name='"+fieldName+"']", form);
			
			// Check Field
			if (field.val() == "") {  
				$(field)
					.toggleClass("error")
					.focus();
				valid = false;
			}				
		}
		
		// Removes any Errors
		$(".error").toggleClass("error");
		
		checkField("password");
		checkField("username");
		
		return valid;			
	});	
	
</script>
	
</body>
</html>