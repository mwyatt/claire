<?php if ($divisions) : ?>
	
<nav class="menu-primary menu-primary-division js-menu-primary-container">
	<span class="menu-primary-reduced-trigger js-menu-primary-toggle">
		<img class="menu-primary-reduced-trigger-image" src="<?php echo $this->getAssetPath('trophy.svg') ?>" onerror="this.src=''; this.onerror=null;">
		<img class="menu-primary-reduced-trigger-image menu-primary-reduced-trigger-cross-image" src="<?php echo $this->getAssetPath('cross.svg') ?>" onerror="this.src=''; this.onerror=null;">
	</span>
	<div class="menu-primary-level-1">
		<a href="<?php echo $this->url->generate() ?>result/" class="menu-primary-level-1-link js-menu-primary-toggle">
			Results
			<img class="menu-primary-level-1-link-image" src="<?php echo $this->getAssetPath('arrow-down.svg') ?>" onerror="this.src=''; this.onerror=null;">
		</a>

		<?php if ($children = $divisions) : ?>

		<div class="menu-primary-level-2">

			<?php foreach ($children as $child) : ?>

			<a href="<?php echo $this->url->build(array('result', $child->name)) ?>" class="menu-primary-level-2-link"><?php echo $child->name ?></a>
				
			<?php
endforeach ?>
	
		</div>

		<?php
endif ?>

	</div>
</nav>

<?php endif ?>
