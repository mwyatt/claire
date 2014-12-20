        </div>
    </div>
	<footer class="container-footer">
		<div class="container-footer-inner">
			<div class="footer-address">
				<a href="<?php echo $this->getUrl() ?>page/contact-us/">&copy; East Lancashire Table Tennis League <?php echo date('Y') ?></a>
				<br>Hyndburn Sports Centre
				<br>Henry Street
				<br>Church
				<br>Accrington
				<br><b>Telephone:</b> 01254 385945
			</div>

<?php $menu = $menuSecondary; ?>
<?php include($this->getTemplatePath('_menu-secondary')) ?>
<?php $menu = $menuTertiary; ?>
<?php include($this->getTemplatePath('_menu-secondary')) ?>

			<a href="http://tabletennisengland.co.uk/" target="_blank" class="logo-table-tennis-england"><img class="logo-table-tennis-england-image" src="<?php echo $this->getUrlMedia('logo-table-tennis-england.gif') ?>" alt="Table Tennis England Logo"></a>
		</div>
	</footer>
    <script src="<?php echo $this->getUrlAsset('vendor/bower/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo $this->getUrlAsset('vendor/bower/owlcarousel/owl-carousel/owl.carousel.min.js') ?>"></script>
    <script src="<?php echo $this->getUrlAsset('vendor/bower/magnific-popup/dist/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?php echo $this->getUrlAsset('asset/main.js') ?>"></script>
</body>
</html>
