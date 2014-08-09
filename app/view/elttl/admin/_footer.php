<?php if ($user): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $this->config->getOption('site_title') . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>

	        <script src="<?php echo $this->getUrlJs('jquery.js?v=1') ?>"></script>
	        <script src="<?php echo $this->getUrl() ?>asset/admin-main.js?v=1"></script>
		</div>
    </body>
</html>
