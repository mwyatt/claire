<?php if (isset($user)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>

		    <script data-main="<?php echo $this->getUrl() ?>js/admin/main" src="<?php echo $this->getUrl() ?>vendor/bower/requirejs/require.js"></script>
		    <script>

		    </script>
		</div>

<?php include($this->getTemplatePath('admin/_feedback-stream-boot')) ?>
		
    </body>
</html>
