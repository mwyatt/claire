        </div>
    </div>
	<footer class="container-footer">
		<div class="container-footer-inner">
			<div class="footer-address">
				<a href="<?php echo $this->url->generate() ?>page/contact-us/">&copy; East Lancashire Table Tennis League <?php echo date('Y') ?></a><br>Hyndburn Sports Centre<br>Henry Street<br>Church<br>Accrington<br><b>Telephone:</b> 01254 385945
            </div>

<?php if (!empty($socials)): ?>

            <div class="footer-socials">
                

    <?php foreach ($socials as $socialName => $socialUrl): ?>
        
                <a href="<?php echo $socialUrl ?>" class="footer-social" title="<?php echo ucwords($socialName) ?>" target="_blank"><?php include $this->getAssetPath($socialName . '.svg') ?></a>

    <?php endforeach ?>

            </div>

<?php endif ?>
<?php $menu = $menuSecondary; ?>
<?php include($this->getTemplatePath('_menu-secondary')) ?>
<?php $menu = $menuTertiary; ?>
<?php include($this->getTemplatePath('_menu-secondary')) ?>

			<a href="http://tabletennisengland.co.uk/" target="_blank" class="logo-table-tennis-england"><img class="logo-table-tennis-england-image" src="<?php echo $this->getUrlAsset('logo-table-tennis-england.gif') ?>" alt="Table Tennis England Logo"></a>
        </div>
    </footer>
    <script src="<?php echo $this->getUrlAsset('vendor/jquery.min.js') ?>"></script>
    <script src="<?php echo $this->getUrlAsset('vendor/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?php echo $this->getUrlAsset('common.js') ?>"></script>
</body>
</html>
