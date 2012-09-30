<?php require_once('app/view/doctype.php'); ?>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
<head>

	<?php require_once('header-actions.php'); ?>

	<!-- Basic Page Title and Metas
	================================================== -->	
	<meta charset="utf-8">
	
	<title>Login to <?php echo $options->get('siteTitle'); ?></title>	
		
	<!-- Meta
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="robots" content="noindex,nofollow">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/skeleton.css'); ?>">
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/layout.css'); ?>">
	<link rel="stylesheet" href="<?php echo $view->urlMedia('css/cc-base.css'); ?>">
	
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

		<div class="logo"><a href="<?php echo $view->urlHome(); ?>" title="Open Homepage"><img src="<?php echo $view->urlMedia('i/logo.png'); ?>" alt="<?php echo $options->get('siteTitle'); ?> Logo"></a></div>

		<form class="login" method="post">

			<input type="hidden" name="form_login" value="true">
			
			<input type="text" name="username" placeholder="Username" autofocus="autofocus">					
			<input type="password" name="password" placeholder="Password">
			
			<br><input class="" type="submit">
			
		</form>

	</div> <!-- / #login -->

</div> <!-- / .container -->

	<!-- Grab Google CDN's jQuery, with a protocol relative URL -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

	<!-- Script
	================================================== -->	
	<script type="text/javascript">
	
		console.log("login.php Initiated");
				
		/**
		  * form#login
		  */
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