			<footer class="container-footer clearfix">
				<div class="footer-inner">
					<span class="attribution">Created By Martin Wyatt</span>
					<nav class="footer-menu">
						<a href="<?php echo $this->url->generate() ?>" class="footer-menu-link">Home</a>
						<a href="<?php echo $this->url->generate() ?>about/" class="footer-menu-link">About Me</a>
						<a href="<?php echo $this->url->generate() ?>" class="footer-menu-link">Download CV</a>
						<a href="<?php echo $this->url->generate() ?>contact/" class="footer-menu-link">Contact Me</a>
					</nav>
				</div>
			</footer>
        </div>

<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>
<?php include $this->getTemplatePath('_require-config') ?>

        <script src="<?php echo $this->url->generate() ?>asset/main.js"></script>
    </body>
</html>
