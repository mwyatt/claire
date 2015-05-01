        </div> <!-- .container-site-inner -->
        </div> <!-- .container-site -->
		<footer class="container-footer">
			<div class="container-footer-inner">
				<div class="footer-socials">
					
<?php foreach ($socials as $socialTitle => $socialUrl): ?>
	
					<a href="<?php echo $socialUrl ?>" class="footer-social" target="_blank"><?php include($this->getAssetPath($socialTitle . '.svg')) ?></a>

<?php endforeach ?>

				</div>
				<div id="search">

<?php include($this->getTemplatePath('_search')) ?>

				</div>
				<div id="menu">

<?php include($this->getTemplatePath('_menu-primary')) ?>

				</div>
					
<?php //include($this->getTemplatePath('_calling-card')) ?>

			</div>
		</footer>

		</div> <!-- .container -->
        <script src="<?php echo $this->getUrlAsset('vendor/jquery.js') ?>"></script>
        <script src="<?php echo $this->getUrlAsset('main.js') ?>"></script>
    </body>
</html>
