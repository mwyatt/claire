<?php if ($divisions) : ?>
	
<nav class="menu-primary menu-primary-division js-menu-primary-container">
	<span class="menu-primary-reduced-trigger js-menu-primary-toggle">
		<span class="menu-primary-reduced-trigger-image"><?php include $this->getAssetPath('trophy.svg') ?></span>
		<span class="menu-primary-reduced-trigger-image menu-primary-reduced-trigger-cross-image"><?php include $this->getAssetPath('cross.svg') ?></span>
	</span>
	<div class="menu-primary-level-1">
		<a href="<?php echo $this->url->generate() ?>result/" class="menu-primary-level-1-link js-menu-primary-toggle">
			Results
			<span class="menu-primary-level-1-link-image"><?php include $this->getAssetPath('arrow-down.svg') ?></span>
		</a>

		<?php if ($children = $divisions) : ?>

		<div class="menu-primary-level-2">

			<?php foreach ($children as $child) : ?>

			<a href="<?php echo $this->url->build(array('result', $child->name)) ?>" class="menu-primary-level-2-link"><?php echo $child->name ?></a>
				
			<?php endforeach ?>
	
		</div>

		<?php
endif ?>

	</div>
</nav>

<?php endif ?>
