			<footer class="container-footer clearfix">
				<div class="footer-inner">
					<span class="attribution">Created By Martin Wyatt</span>
					<nav class="footer-menu">
						<a href="<?php echo $this->getUrl() ?>" class="footer-menu-link">Home</a>
						<a href="<?php echo $this->getUrl() ?>about/" class="footer-menu-link">About Me</a>
						<a href="<?php echo $this->getUrl() ?>" class="footer-menu-link">Download CV</a>
						<a href="<?php echo $this->getUrl() ?>contact/" class="footer-menu-link">Contact Me</a>
					</nav>
				</div>
			</footer>
        </div>

<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>
<?php include $this->getTemplatePath('_require-config') ?>

	    <script data-main="main" src="<?php echo $this->getUrl() ?>vendor/bower/requirejs/require.js"></script>
        <!-- // <script src="<?php echo $this->getUrl() ?>asset/main.js?v=1"></script> -->
    </body>
</html>
