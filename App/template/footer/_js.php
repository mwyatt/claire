<?php if (isset($asset['js'])): ?>
	<?php foreach ($asset['js'] as $path): ?>

<script src="<?php echo $this->getUrlAsset($path . '.js') ?>"></script>
		
	<?php endforeach ?>
<?php endif ?>
