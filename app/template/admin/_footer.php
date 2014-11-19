<?php if ($user): ?>

			<footer class="main clearfix">
				<p class="footer-site-title"><?php echo $option['site_title']->getValue() . ' ' . date('Y') ?></p>
			</footer>
			
<?php endif ?>

		    <script src="<?php echo $this->getUrlAsset('vendor/bower/jquery/dist/jquery.min.js') ?>"></script>
		    <script src="<?php echo $this->getUrlAsset('asset/admin-main.js') ?>"></script>
		</div>
    </body>
</html>
