<?php if ($menu) : ?>
	
<nav class="menu-primary menu-primary-league js-menu-primary-container">
	<span class="menu-primary-reduced-trigger js-menu-primary-toggle">
		<img class="menu-primary-reduced-trigger-image" src="<?php echo $this->getAssetPath('menu.svg') ?>" onerror="this.src=''; this.onerror=null;">
		<img class="menu-primary-reduced-trigger-image menu-primary-reduced-trigger-cross-image" src="<?php echo $this->getAssetPath('cross.svg') ?>" onerror="this.src=''; this.onerror=null;">
	</span>

	<?php foreach ($menu as $menuItem) : ?>

	<div class="menu-primary-level-1">
		<a href="<?php echo $this->url->generate() . $menuItem->url ?>" class="menu-primary-level-1-link js-menu-primary-toggle">

		<?php echo $menuItem->name ?>

			<img class="menu-primary-level-1-link-image" src="<?php echo $this->getAssetPath('arrow-down.svg') ?>" onerror="this.src=''; this.onerror=null;">
		</a>

		<?php if ($menuItem->children) : ?>

		<div class="menu-primary-level-2">

			<?php foreach ($menuItem->children as $child) : ?>

			<a href="<?php echo $this->url->generate() . $child->url ?>" class="menu-primary-level-2-link"><?php echo $child->name ?></a>
				
			<?php
endforeach ?>
	
		</div>

		<?php
endif ?>

	</div>

	<?php
endforeach ?>
	
</nav>

<?php endif ?>
