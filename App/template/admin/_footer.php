<?php if (isset($user)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>

		    <script src="<?php echo $this->getUrl() ?>js/config.js"></script>
		    <script data-main="<?php echo $this->getUrl() ?>js/admin-main" src="<?php echo $this->getUrl() ?>js/vendor/require.js"></script>
		</div>

<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>
		
    </body>
</html>
