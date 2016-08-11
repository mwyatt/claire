<?php if ($menu): ?>
	
<nav class="menu">

	<?php foreach ($menu as $menuItem): ?>

	<a href="<?php echo $this->url->generate() . $menuItem->url ?>" class="menu-item"><?php echo $menuItem->name ?></a>

	<?php endforeach ?>
	
</nav>

<?php endif ?>
