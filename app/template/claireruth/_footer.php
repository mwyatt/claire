        </div> <!-- .container-site-inner -->
        </div> <!-- .container-site -->
		<footer class="container-footer">
			<div class="container-footer-inner">
				<div class="footer-socials">
					
<?php foreach (array('twitter' => 'https://twitter.com/clmruth', 'facebook' => 'https://www.facebook.com/clurrrpoof', 'pinterest' => 'http://www.pinterest.com/clmruth26/', 'google' => 'https://plus.google.com/100076113648548258052') as $socialTitle => $socialUrl): ?>
	
					<a href="<?php echo $socialUrl ?>" class="footer-social" target="_blank"><?php include($this->getPathMedia($socialTitle . '.svg')) ?></a>

<?php endforeach ?>

				</div>
				<div id="search">

<?php include($this->pathView('_search')) ?>

				</div>
				<div id="menu">

<?php $menu = $mainMenu; ?>
<?php include($this->pathView('_menu')) ?>

				</div>
					
<?php //include($this->pathView('_calling-card')) ?>

			</div>
		</footer>

		</div> <!-- .container -->
        <script src="<?php echo $this->getUrlJs('jquery.js') ?>"></script>
        <script src="<?php echo $this->getUrl() ?>asset/main.js<?php echo $this->getAssetVersion() ?>"></script>
    </body>
</html>
