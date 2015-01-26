<?php if (isset($user)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>

			<script type="text/javascript">
			    var require = {
			        baseUrl: '<?php echo $this->getUrl() ?>js/',
			        urlArgs: 'bust=' +  (new Date()).getTime(),
			    	paths: {
			    	  'jquery': 'vendor/jquery/jquery',
			    	  'mustache': 'vendor/mustache/mustache',
			    	  'jquerySerializeObject': 'vendor/jquery-serialize-object/jquery.serialize-object.min',
			    	  'magnificPopup': 'vendor/magnific-popup/jquery.magnific-popup'
			    	},
			    	shim: {
			    	  'jquerySerializeObject': {
			    	    deps: ['jquery']
			    	  },
			    	  'magnificPopup': {
			    	    deps: ['jquery']
			    	  }    
			    	}
			    };
			</script>
		    <script data-main="admin-main" src="<?php echo $this->getUrl() ?>vendor/bower/requirejs/require.js"></script>
		    <script>

		    </script>
		</div>

<?php include($this->getTemplatePath('admin/_feedback-stream-boot')) ?>
		
    </body>
</html>
