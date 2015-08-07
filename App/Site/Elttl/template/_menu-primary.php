<?php if ($menu) : ?>
	
<nav class="menu-primary menu-primary-league js-menu-primary-container">
	<span class="menu-primary-reduced-trigger js-menu-primary-toggle">
		<span class="menu-primary-reduced-trigger-image"><?php include $this->getAssetPath('menu.svg') ?></span>
		<span class="menu-primary-reduced-trigger-image menu-primary-reduced-trigger-cross-image"><?php include $this->getAssetPath('cross.svg') ?></span>
	</span>

	<?php foreach ($menu as $menuItem) : ?>

	<div class="menu-primary-level-1">
		<a href="<?php echo $this->url->generate() . $menuItem->url ?>" class="menu-primary-level-1-link js-menu-primary-toggle">

		<?php echo $menuItem->name ?>

			<span class="menu-primary-level-1-link-image"><?php include $this->getAssetPath('arrow-down.svg') ?></span>
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
