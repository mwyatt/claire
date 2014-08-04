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
        <script src="<?php echo $this->getUrlJs('jquery.js?v=1') ?>"></script>
        <script src="<?php echo $this->getUrl() ?>asset/main.js?v=1"></script>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-43311305-1', 'auto');
          ga('send', 'pageview');

        </script>
    </body>
</html>
