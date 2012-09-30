</div> <!-- / .container -->

<footer class="base">

	<div class="container">
		<div class="eight columns">
			<div class="profile">
				<p class="name"><?php echo $options->get('site_title'); ?></p>
				<p class="description">Web Designer</p>
			</div>			
		</div>		
		<div class="eight columns">
			<div class="tweet">
				<span></span>
				<p class="text"><?php $view->latestTweet("mawyatt"); ?></p>	
			</div>		
		</div>		
	</div> <!-- / .container -->

	<!--<a href="mailto:<?php echo $options->get('site_email'); ?>"><?php echo $options->get('site_email'); ?></a>-->
	
</footer>

	<!-- JQuery -->
	<script src="<?php echo $view->urlHome(); ?>media/js/jquery.min.js"></script>	

	<!-- Scripts
	================================================== -->
	<script src="<?php echo $view->urlMedia('js/jquery.flexslider-min.js'); ?>" type="text/javascript"></script>  
	<script src="<?php echo $view->urlMedia('js/script.js'); ?>" type="text/javascript"></script>  

	<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
	   mathiasbynens.be/notes/async-analytics-snippet -->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
	
</body>
</html>