<?php if (isset($division)): ?>

<a href="<?php echo $this->url->build(array('result', $division->getName())) ?>" class="division">
	<img class="division-image" src="<?php echo $this->getAssetPath('trophy.svg') ?>" onerror="this.src=''; this.onerror=null;">
	<span class="division-name"><?php echo $division->getName() ?></span>
</a>

<?php endif ?>
