<?php if (isset($user)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>
<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>

<?php if (isset($tinymce)): ?>
	
		    <script src="<?php echo $this->getUrl() ?>asset/vendor/tinymce/tinymce.min.js"></script>
	
<?php endif ?>

		    <script src="<?php echo $this->getUrl() ?>asset/admin/main.js"></script>
		</div>
    </body>
</html>
