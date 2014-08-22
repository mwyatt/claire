<?php if ($menu): ?>
	
<nav class="menu-primary">

	<?php foreach ($menu as $menuItem): ?>

	<a href="<?php echo $this->getUrl() . $menuItem->url ?>" class="menu-primary-item"><?php echo $menuItem->name ?></a>

	<?php endforeach ?>
	
</nav>

<?php endif ?>
