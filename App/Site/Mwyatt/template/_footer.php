			</div> <!-- .page-container -->
			<footer class="container-footer clearfix">
				<div class="footer-inner">
					<nav class="footer-menu">
						<a href="#top" class="footer-menu-link js-smooth-scroll">Home</a>
						<a href="#about-me" class="footer-menu-link js-smooth-scroll">About Me</a>
						<a href="<?php echo $this->getUrlAsset('cv.pdf') ?>" class="footer-menu-link">Download CV</a>
						<a href="#skills" class="footer-menu-link js-smooth-scroll">Skills</a>
					</nav>
					<div class="footer-profile">
						<div class="footer-profile-avatar">
							<img class="footer-profile-avatar-image" src="<?php echo $this->getUrlAsset('avatar/holiday.jpg') ?>" alt="Martin Wyatt">
						</div>
						<h3 class="footer-profile-greeting">Hey</h3>
						<p class="p">My name is Martin. I work at AV Distribution as a Front End Web Developer. I spend my days designing and implementing web interfaces.</p>
					</div>
					<div class="footer-contact">
						<h3 class="footer-profile-greeting">Get in touch</h3>
						<div class="typography">
							<p class="p">You can find me on <a href="https://twitter.com/mawyatt" title="@mawyatt" target="_blank">Twitter</a> and <a href="mailto:martin.wyatt@gmail.com">Email</a>.</p>
						</div>
					</div>
				</div>
			</footer>
        </div>

<?php include $this->getTemplatePath('admin/_feedback-stream-boot') ?>
<?php include $this->getTemplatePath('_require-config') ?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->getUrlAsset(\'vendor/jquery.js\') ?>"><\/script>')</script>
        <script src="<?php echo $this->getUrlAsset('main.js') ?>"></script>
    </body>
</html>
