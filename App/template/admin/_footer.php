<?php if (isset($user)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>
<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>

		    <script src="<?php echo $this->url->generate() ?>asset/admin/main.js"></script>
		</div>
    </body>
</html>
