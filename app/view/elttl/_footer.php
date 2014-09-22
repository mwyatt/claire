        </div>
    </div>
	<footer class="container-footer">
		<div class="container-footer-inner">

<?php $menu = $menuSecondary; ?>
<?php include($this->pathView('_menu-Secondary')) ?>

			<div class="footer-address">
				<a href="<?php echo $this->getUrl() ?>page/contact-us/">&copy; East Lancashire Table Tennis League <?php echo date('Y') ?></a>
				<br>Hyndburn Sports Centre
				<br>Henry Street
				<br>Church
				<br>Accrington
				<br><b>Telephone:</b> 01254 385945
			</div>
			<a href="http://tabletennisengland.co.uk/" target="_blank" class="logo-table-tennis-england"><img class="logo-table-tennis-england-image" src="<?php echo $this->getUrlMedia('logo-table-tennis-england.gif') ?>" alt="Table Tennis England Logo"></a>
		</div>
	</footer>
    <script src="<?php echo $this->getUrlJs('jquery.js?v=1') ?>"></script>
    <script src="<?php echo $this->getUrl() ?>asset/main.js?v=1"></script>
    <script>
    </script>
</body>
</html>
