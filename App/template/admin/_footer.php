<?php if (isset($adminUser)): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $metaTitle . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>
<?php include $this->getTemplatePath('footer/_mustache') ?>
<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>
<?php include $this->getTemplatePath('footer/_js') ?>

		</div>
    </body>
</html>
