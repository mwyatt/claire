<?php if ($menu): ?>
	
<nav class="menu-secondary">

	<?php foreach ($menu as $menuItem): ?>

	<a href="<?php echo $this->getUrl() . $menuItem->url ?>" class="menu-secondary-item"><?php echo $menuItem->name ?></a>

	<?php endforeach ?>
	
</nav>

<?php endif ?>