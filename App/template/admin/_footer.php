<?php if (isset($user)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>

		    <script src="<?php echo $this->getUrlAsset('admin/vendor/jquery/jquery.js') ?>"></script>
		    <script src="<?php echo $this->getUrlAsset('admin/vendor/tinymce/tinymce.js') ?>"></script>
		    <script src="<?php echo $this->getUrlAsset('admin/main.js') ?>"></script>
		</div>

<?php include($this->getTemplatePath('admin/_feedback-stream-boot')) ?>
		
    </body>
</html>
