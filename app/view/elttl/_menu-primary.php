<?php if ($menu): ?>
	
<nav class="menu-primary js-menu-primary-container">

	<?php foreach ($menu as $menuItem): ?>

	<div class="menu-primary-level-1">
		<a href="<?php echo $this->getUrl() . $menuItem->url ?>" class="menu-primary-level-1-link js-menu-primary-toggle">

		<?php echo $menuItem->name ?>

			<img class="menu-primary-level-1-link-image" src="<?php echo $this->getUrlMedia('arrow-down.svg') ?>" onerror="this.src=''; this.onerror=null;">
		</a>

		<?php if ($menuItem->children): ?>

		<div class="menu-primary-level-2">

			<?php foreach ($menuItem->children as $child): ?>

			<a href="<?php echo $this->getUrl() . $child->url ?>" class="menu-primary-level-2-link"><?php echo $child->name ?></a>
				
			<?php endforeach ?>
	
		</div>

		<?php endif ?>

	</div>

	<?php endforeach ?>
	
</nav>

<?php endif ?>
